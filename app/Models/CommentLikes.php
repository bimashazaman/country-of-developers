<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentLikes extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function likedBy(User $user)
    {
        return $this->likes->contains('user_id', $user->id);
    }

    public function toggleLike(User $user)
    {
        if ($this->likedBy($user)) {
            return $this->likes()->where('user_id', $user->id)->delete();
        } else {
            return $this->likes()->create(['user_id' => $user->id]);
        }
    }
}
