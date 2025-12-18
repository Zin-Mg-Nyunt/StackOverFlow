<?php

namespace App\Services;

use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class QuestionService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function createQuestion($data){
        $data['user_id']=Auth::id();
        return Question::create($data);
    }
}
