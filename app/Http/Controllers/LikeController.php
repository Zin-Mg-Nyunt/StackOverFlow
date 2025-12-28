<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(){
        $data=request()->validate([
            "likeable_type"=> "required | in:question,answer",
            "likeable_id"=> "required | integer",
        ]);
        $modelClass=$data['likeable_type'] === 'question' ? Question::class : Answer::class;
        $model=$modelClass::findOrFail($data['likeable_id']);
        $model->likes()->toggle(Auth::id());
        return back();
    }
}
