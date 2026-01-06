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

    // framework's method. This is auto running in backend when a class was created. We use this because we want add some custom logic in this state
    protected static function boot()
    {
        parent::boot(); 

        // custom logic
        static::created(function($answer){ // this run when an answer was created
            if ($answer->parent_id) {
                $answer->incrementParentCount();
            }
        });

        static::deleted(function($answer){ // this run when an answer was deleted
            if($answer->parent_id){
                $answer->decrementParentCount();
            }
        });
    }
    public function incrementParentCount(){
        $parent=$this->parent; // call parent answer (father state)
        if($parent){ // check parent has or not
            $parent->increment("total_replies_count");
            $parent->incrementParentCount(); // making recursive method and cause grandfather state and up till to root answer
        }
    }
    public function decrementParentCount(){
        $parent=$this->parent; // call parent answer (father state)
        if($parent){ // check parent has or not
            $parent->decrement("total_replies_count");
            $parent->decrementParentCount(); // making recursive method and cause grandfather state and up till to root answer
        }
    }

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

    // parent answer (one to one) self-referencing relationship
    public function parent(){
        return $this->belongsTo(Answer::class,"parent_id");
    }
    // child answers (one to many) self-referencing relationship
    public function replies(){
        return $this->hasMany(Answer::class,"parent_id");
    }
    // latest reply from many replies
    public function latestReply(){
        return $this->hasOne(Answer::class, "parent_id")
                    ->latestOfMany();
    } 
}
