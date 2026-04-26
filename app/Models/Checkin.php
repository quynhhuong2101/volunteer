<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'checkin_time',
        'checkout_time',
        'location_data', // JSON: {lat, long, accuracy}
        'device_info',
        'is_verified',
    ];

    protected $casts = [
        'checkin_time' => 'datetime',
        'checkout_time' => 'datetime',
        'location_data' => 'array',
        'is_verified' => 'boolean',
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
