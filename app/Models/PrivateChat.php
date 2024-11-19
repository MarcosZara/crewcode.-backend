<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivateChat extends Model
{
    use HasFactory;

    protected $fillable = ['user1_id', 'user2_id'];

    public function messages()
    {
        return $this->hasMany(PrivateMessages::class, 'chat_id');
    }
}
