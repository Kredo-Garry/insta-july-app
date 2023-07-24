<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    # A post belongs to a user
    # Use this method to get owner of the post
    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }

    # To get the categories under a post
    # hasMany() --> 1 to many
    public function categoryPost(){
        return $this->hasMany(CategoryPost::class);
    }

    # Use this to get all the comments, and what post has been commented
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    # Use this method to get the like of the post
    public function likes(){
        return $this->hasMany(Like::class);
    }

    # Return TRUE if the Auth user id is found in likes table
    public function isLiked(){
        return $this->likes()->where('user_id', Auth::user()->id)->exists();
    }
}
