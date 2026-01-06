<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Services\AnswerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnswerController extends Controller
{
    public function store(Question $question, Request $request){
       
        $newData=$request->validate([
            "body" => "required",
            "parent_id" => "nullable|exists:answers,id"
        ]);
        $newAnswer=DB::transaction(function() use($request,$question,$newData){
            $newData["user_id"] = $request->user()->id;
            return $question->answers()->create($newData);
        });
        // add requried attribute after new reply create
        $newAnswer->load('author');
        $newAnswer->setAttribute('isLiked',false);
        $newAnswer->setAttribute('likes_count',0);

        // check where it comes from creating root answer(inertia useForm) or reply answer(axios)
        if ($request->has('parent_id') && $request['parent_id'] !== null) { // if it has parent_id, it is reply answer so return json data
            return response()->json($newAnswer);
        }
        return back(); // or it is root answer so just return back to make soft reload and fetch props again
    }
    public function replies(Answer $answer,AnswerService $answerService){
        $replies=$answerService->getReplies($answer);
        return response()->json($replies); // use response and json to partial update in already page
    }
}
