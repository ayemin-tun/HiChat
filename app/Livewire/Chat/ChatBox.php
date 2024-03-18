<?php

namespace App\Livewire\Chat;

use App\Models\Message;
use Livewire\Attributes\On;
use Livewire\Component;

class ChatBox extends Component
{
    public $selectedConversation;

    public $body;

    public $loadedMessages;

    public $message_show_limit;

    public function __construct()
    {
        $this->message_show_limit = config('app.message_show_limit');
    }

    #[On('loadMore')]
    public function loadMore()
    {
        // increase the data
        $this->message_show_limit += 10;
        // load message
        $this->loadMessages();
        // update the chat height
        $this->dispatch('update-chat-height');
    }

    public function mount()
    {
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $count = Message::where('conversation_id', $this->selectedConversation->id)->count();

        $this->loadedMessages = Message::where('conversation_id', $this->selectedConversation->id)
            ->skip($count - $this->message_show_limit)
            ->take($this->message_show_limit)
            ->get();

        return $this->loadedMessages;
    }

    public function sendMessage()
    {
        $this->validate([
            'body' => 'required|string',
        ]);

        $createdMessage = Message::create([
            'conversation_id' => $this->selectedConversation->id,
            'sender_id' => auth()->id(),
            'receiver_id' => $this->selectedConversation->getReceiver()->id,
            'body' => $this->body,
        ]);
        $this->reset(['body']);

        // scroll the bottom where message is newly send
        $this->dispatch('scroll-bottom');
        //auto update the message box
        $this->loadedMessages->push($createdMessage);

        //make conversition update list to top
        $this->selectedConversation->updated_at = now();
        $this->selectedConversation->save();

        // refresh chatList and also scroll that chat chatlist
        // $this->dispatchTo('chat.chat-list', 'refresh'); //livewire version 2
        $this->dispatch('refresh')->to(ChatList::class);
    }

    public function render()
    {
        return view('livewire.chat.chat-box');
    }
}
