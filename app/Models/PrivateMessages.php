<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivateMessages extends Model
{
    use HasFactory;

    protected $fillable = ['chat_id', 'sender_id', 'message_content'];

    public function chat()
    {
        return $this->belongsTo(PrivateChat::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
