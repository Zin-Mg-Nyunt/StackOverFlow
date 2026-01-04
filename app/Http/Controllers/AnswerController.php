<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Services\AnswerService;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function store(Question $question, Request $request){
        $newAnswer=request()->validate([
            "body" => "required",
        ]);
        $newAnswer["user_id"] = $request->user()->id;
        $question->answers()->create($newAnswer);
    }
    public function replies(Answer $answer,AnswerService $answerService){
        $replies=$answerService->getReplies($answer);
        return response()->json($replies); // use response and json to partial update in already page
    }
}
