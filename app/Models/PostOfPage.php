<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostOfPage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    //likes
    public function likes()
    {
        return $this->hasMany(Likes::class, 'post_id');
    }

    //comments
    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }
}
