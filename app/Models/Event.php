<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_time',
        'end_time',
        'location',
        'status', // 'draft', 'pending', 'approved', 'rejected', 'changes_requested'
        'organizer_id',
        'max_participants',
        'qr_token', // Dynamic token for generation
        'image',
        'scope',
        'is_registration_paused',
        'requirements',
        'benefits',
        'contact_name',
        'contact_phone',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'requirements' => 'array',
        'benefits' => 'array',
    ];

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function budget()
    {
        return $this->hasOne(Budget::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function checkins()
    {
        return $this->hasMany(Checkin::class);
    }

    public function schedules()
    {
        return $this->hasMany(EventSchedule::class)->orderBy('date')->orderBy('start_time');
    }

    public function getSlotsAttribute()
    {
        return $this->max_participants;
    }

    public function getRegisteredAttribute()
    {
        return $this->checkins()->count();
    }

    // Dynamic Status Accessor
    public function getEffectiveStatusAttribute()
    {
        if ($this->status == 'cancelled') return 'cancelled';
        if ($this->status == 'rejected') return 'rejected';
        if ($this->status == 'pending') return 'pending';
        
        // If approved, check time
        $now = now();
        if ($now->lt($this->start_time)) return 'upcoming'; // Approved but not started
        if ($now->between($this->start_time, $this->end_time)) return 'ongoing';
        if ($now->gt($this->end_time)) return 'ended';

        return $this->status;
    }

    public function getCanRegisterAttribute()
    {
        if ($this->effective_status !== 'upcoming') return false;
        if ($this->max_participants && $this->registered >= $this->max_participants) return false;
        return true;
    }


    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function positions()
    {
        return $this->hasMany(EventPosition::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
