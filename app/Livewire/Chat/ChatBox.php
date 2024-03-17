<?php

namespace App\Livewire\Chat;

use App\Models\Message;
use Livewire\Component;

class ChatBox extends Component
{
    public $selectedConversation;

    public $body;

    public $loadedMessages;

    public function mount()
    {
        $this->loadMessages();
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

    public function loadMessages()
    {
        $this->loadedMessages = Message::where('conversation_id', $this->selectedConversation->id)->get();
    }

    public function render()
    {
        return view('livewire.chat.chat-box');
    }
}
