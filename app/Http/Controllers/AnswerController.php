<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function store(Question $question){
        $newAnswer=request()->validate([
            "body" => "required|min:5",
        ]);
        $newAnswer["user_id"] = auth()->id();
        $question->answers()->create($newAnswer);
    }
}
