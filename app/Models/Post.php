<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Likes::class);
    }

    public function likedBy(User $user)
    {
        return $this->likes->contains('user_id', $user->id);
    }

    public function like(User $user)
    {
        if ($this->likedBy($user)) {
            return;
        }

        $this->likes()->create([
            'user_id' => $user->id,
        ]);
    }

    public function unlike(User $user)
    {
        $this->likes()->where('user_id', $user->id)->delete();
    }

    public function toggleLike(User $user)
    {
        if ($this->likedBy($user)) {
            return $this->unlike($user);
        }

        return $this->like($user);
    }

    public function getLikesCountAttribute()
    {
        return $this->likes->count();
    }

    public function getCommentsCountAttribute()
    {
        return $this->comments->count();
    }

    //relationship with comment
    public function comment()
    {
        return $this->hasMany(Comment::class);
    }


    public function sharedPost()
    {
        return $this->hasMany(SharedPost::class, 'post_id');
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
