<?php

namespace App\Livewire\Chat;

use App\Models\Message;
use App\Notifications\MessageSent;
use App\Services\MessageService;
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

    public function getListeners()
    {
        $auth_id = auth()->user()->id;

        // listen the event from pusher
        return [
            "echo:private-users.{$auth_id},.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated" => 'broadcastedNotifications',
        ];
    }

    public function broadcastedNotifications($event)
    {
        // dd($event['type']);
        if ($event['type'] == MessageSent::class) {
            // check to prevent wrong message to wrong conversation
            if ($event['conversation_id'] == $this->selectedConversation->id) {
                // scroll the bottom where message is newly send
                $this->dispatch('scroll-bottom');
                $newMessage = Message::find($event['message_id']);
                //auto update the message box
                $this->loadedMessages->push($newMessage);

                $this->dispatch('refresh')->to(ChatList::class);
            }
        }
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

    public function sendMessage(MessageService $messageService)
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

        // refresh chatList and also scroll that chat chatlist
        // $this->dispatchTo('chat.chat-list', 'refresh'); //livewire version 2
        $this->dispatch('refresh')->to(ChatList::class);

        // broadcast for this work need to run php artisan queue:work
        $this->selectedConversation->getReceiver()
            ->notify(new MessageSent(
                Auth()->User(),
                $createdMessage,
                $this->selectedConversation,
                $this->selectedConversation->getReceiver()->id
            ));

        // // Make message that send from sender is to read
        // $messageService->makeMessageRead($this->selectedConversation->id);

        //make conversition update list to top
        $this->selectedConversation->updated_at = now();
        $this->selectedConversation->save();
    }

    public function render()
    {
        return view('livewire.chat.chat-box');
    }
}
