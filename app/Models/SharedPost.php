<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharedPost extends Model
{
    use HasFactory;

    protected $guarded = [];


    // relation with posts
    public function originalPost()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
