<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'name', 'type'];

    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
