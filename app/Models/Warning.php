<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warning extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // Organization ID
        'title',
        'content',
        'severity', // reminder, warning, ban
        'is_read'
    ];
    
    protected $casts = [
        'is_read' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
