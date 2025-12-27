<?php

namespace App\Services;

use App\Models\User;

class UserService{
    public function __construct(){

    }
    public function getUser($user){
        return $user->loadCount([
                    'questions',
                    'answers',
                    'savedQuestions'
                ]);
    }
    public function getQuestions($user){
        return $user->questions()
                    ->withCount(['answers','votes'])
                    ->latest()
                    ->take(5)
                    ->get();
    }
    public function getSavedQuestions($user){
        return $user->savedQuestions()
                    ->withCount(['answers','votes'])
                    ->orderByPivot('created_at','desc') // order desc by bookmark time
                    ->paginate(3)
                    ->withQueryString();         
    }
    public function getAnswers($user){
        return $user->answers()
                    ->with(['question'])
                    ->latest()
                    ->paginate(3)
                    ->withQueryString();
    }
}