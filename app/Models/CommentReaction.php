<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentReaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_comment_id',
        'user_id',
        'type', // like, dislike
    ];

    public function comment()
    {
        return $this->belongsTo(PostComment::class, 'post_comment_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
