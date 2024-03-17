<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'receiver_id',
        'sender_id',
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function getReceiver()
    {
        // check if the sender is auth then other user is receiver if the sender is not auth the other user is sender
        if ($this->sender_id == auth()->id()) {
            return User::firstWhere('id', $this->receiver_id);
        } else {
            return User::firstWhere('id', $this->sender_id);
        }
    }

    public function unreadMessageCount(): int
    {
        return Message::where('conversation_id', $this->id)->where('receiver_id', auth()->user()->id)->whereNull('read_at')->count();
    }

    public function isNewMessage(): bool
    {
        return $this->unreadMessageCount() > 0;
    }
}
