<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Message;
use App\Services\MessageService;
use Livewire\Component;

class Chat extends Component
{
    public $query;

    public $selectedConversation;

    public function mount(MessageService $messageService)
    {
        $this->selectedConversation = Conversation::findOrFail($this->query);
        // Make message that send from sender is to read
        $messageService->makeMessageRead($this->selectedConversation->id);

    }

    public function render()
    {
        return view('livewire.chat.chat');
    }
}
