<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use Livewire\Attributes\On;
use Livewire\Component;

class ChatList extends Component
{
    public $selectedConversation;

    public $query;

    #[On('refresh')]
    public function render()
    {
        $user = auth()->user();

        return view('livewire.chat.chat-list', [
            'conversations' => $user->conversations()->latest('updated_at')->get(),
        ]);
    }

    public function deleteByUser($id)
    {
        $conversation_id = decrypt($id);
        $user_id = auth()->id();
        $conversation = Conversation::findOrFail($conversation_id);

        $conversation->messages()->each(function ($message) use ($user_id) {
            if ($message->sender_id === $user_id) {
                $message->update(['sender_deleted_at' => now()]);
            } elseif ($message->receiver_id === $user_id) {
                $message->update(['receiver_deleted_at' => now()]);
            }
        });

        $receiverAlsoDeleted = $conversation->messages()
            ->where(function ($query) use ($user_id) {
                $query->where('sender_id', $user_id)
                    ->orWhere('receiver_id', $user_id);
            })->where(function ($query) {
                $query->whereNull('sender_deleted_at')
                    ->orWhereNull('receiver_deleted_at');
            })->doesntExist();

        if ($receiverAlsoDeleted) {
            $conversation->delete();
        }

        return redirect(route('chat.index'));
    }

    #[On('refresh')]
    public function scrollTop()
    {
        $this->dispatch('scroll-top');
    }
}
