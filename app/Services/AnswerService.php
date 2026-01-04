<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class AnswerService{
    public function __construct(){
    }
    public function getAnswers($question){
        return $question->answers()
                    ->whereNull('parent_id') // get only root answers
                    ->with('userVote','latestReply') // get latest reply with author and user vote
                    ->withCount([
                        'upvotes','downvotes','likes','replies',
                        'likes as isLiked'=>fn($a)=> $a->where('user_id',Auth::id())])
                    ->when(request('sort') === 'latest', function($query){$query->latest();})
                    ->paginate(3)
                    ->through(fn($a)=> $this->formatAnswer($a))
                    ->withQueryString();
    }
    public function getReplies($answer){
        return $answer->replies()
                    ->with('userVote','parent','latestReply') // get parent answer and latest reply with author and user vote
                    ->withCount([
                        'upvotes','downvotes','likes','replies',
                        'likes as isLiked'=>fn($a)=> $a->where('user_id',Auth::id())])
                    ->oldest()
                    ->paginate(10)
                    ->through(fn($a)=> $this->formatAnswer($a))
                    ->withQueryString();
    }
    protected function formatAnswer($a){
        $a->authorized = $a->user_id === Auth::id();
        $a->likedUser = $a->isLiked > 0;
        return $a;
    }
}