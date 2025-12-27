<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /** @use HasFactory<\Database\Factories\QuestionFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['author','tags'];

    public function author(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function tags(){
        return $this->belongsToMany(Tag::class);
    }
    public function answers()
    {
        return $this->hasMany(Answer::class,'question_id');
    }
    public function votes(){
        return $this->morphMany(Vote::class,"votable");
    }
    public function savedUsers(){
        return $this->belongsToMany(User::class,"question_user");
    }

    public function scopeFilter($query,$filter){
        $query->when($filter['search']??false,function($query,$search){
            $query->where(function($query) use($search){
                $query->where('title','LIKE','%'.$search.'%')
                    ->orWhere('body','LIKE','%'.$search.'%');
            });
        });
        $query->when($filter['tag']??false,function($query,$slug){
            $query->wherehas('tags',function($query) use($slug){
                $query->where('slug',$slug);
            });
        });
    }

    public function getImageUrlAttribute($value){
        if($value){
            return asset('storage/'.$value);
        }
        return null;
    }
    public function upvotes(){
        return $this->votes()->where("value","upvote");
    }
    public function downvotes(){
        return $this->votes()->where("value","downvote");
    }
}
