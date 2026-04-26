<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'title', 'description', 'is_active'];

    public function questions()
    {
        return $this->hasMany(FormQuestion::class)->orderBy('order');
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
