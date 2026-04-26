<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['form_question_id', 'user_id', 'answer'];

    public function question()
    {
        return $this->belongsTo(FormQuestion::class, 'form_question_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
