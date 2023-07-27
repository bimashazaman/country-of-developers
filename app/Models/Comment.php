<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment',
        'user_id',
        'post_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function replies()
    {
        return $this->hasMany(CommentReply::class);
    }

    public function likes()
    {
        return $this->hasMany(CommentLikes::class);
    }

    //isLikedByUser
    public function isLikedByUser($user_id)
    {
        return $this->likes->where('user_id', $user_id)->count() > 0;
    }

    //post of page
    public function postOfPage()
    {
        return $this->belongsTo(PostOfPage::class);
    }
}
