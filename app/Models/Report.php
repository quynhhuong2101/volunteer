<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'title', // Issue type or summary
        'description',
        'evidence', // JSON or path
        'status', // open, resolved, rejected
        'resolution_note'
    ];

    protected $casts = [
        'evidence' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
