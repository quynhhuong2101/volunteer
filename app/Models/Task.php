<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'position_id',
        'title',
        'description',
        'deadline',
        'status',
        'priority',
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function position()
    {
        return $this->belongsTo(EventPosition::class);
    }

    public function completions()
    {
        return $this->hasMany(TaskCompletion::class);
    }
}