<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /** @use HasFactory<\Database\Factories\QuestionFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['author'];

    public function author(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function scopeFilter($query,$filter){
        $query->when($filter['search']??false,function($query,$search){
            $query->where('title','LIKE','%'.$search.'%');
        });
    }
}
