<?php

namespace App\Http\Controllers;

use App\Models\Question;
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
}
