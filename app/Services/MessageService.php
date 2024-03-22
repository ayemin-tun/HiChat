<?php

namespace App\Services;

use App\Models\Message;

class MessageService
{
    public function makeMessageRead($conversation_id)
    {
        return Message::where('conversation_id', $conversation_id)
            ->where('receiver_id', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }
}
