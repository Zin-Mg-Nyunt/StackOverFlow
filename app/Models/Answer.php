<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Answer extends Model
{
    /** @use HasFactory<\Database\Factories\AnswerFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['author'];

    public function question(){
        return $this->belongsTo(Question::class, 'question_id');
    }
    public function author(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function votes(){
        return $this->morphMany(Vote::class,"votable");
    }
    public function likes(){
        return $this->morphToMany(User::class, "likeable", "likes", "likeable_id", "user_id");
    }

    public function upvotes(){
        return $this->votes()->where("value","upvote");
    }
    public function downvotes(){
        return $this->votes()->where("value","downvote");
    }

    public function userVote(){
        return $this->morphOne(Vote::class, "votable")
                    ->where('user_id',Auth::id());
    }
    public function likedUser(){
        return $this->likes()->where('user_id',Auth::id());
    }
}
