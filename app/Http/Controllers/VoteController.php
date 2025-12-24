<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function toggle(){
        $voteData=request()->validate([
            "votable_type"=> "required | in:question,answer",
            "votable_id"=> "required | integer",
            "value"=> "required | in:upvote,downvote",
        ]);

        $vote=Vote::firstOrNew([
            "votable_type"=>$voteData['votable_type'] === 'question' ? Question::class: Answer::class,
            "votable_id"=>$voteData['votable_id'],
            "user_id"=>Auth::id()
        ]);
        if($vote->exists && $vote->value === $voteData['value']){
            $vote->delete();
            return;
        }
        $vote->value = $voteData['value'];
        $vote->save();
        return;
    }
}
