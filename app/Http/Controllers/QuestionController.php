<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function index(){
            return inertia('Questions/Index', [
                'questions' => Question::filter(request(['search','tag']))->latest()->get(),
                'filters' => request(['search','tag'])
            ]);
    }
    public function show(Question $question){
        return inertia('Questions/Detail',[
            'question' => $question
        ]);
    }
    public function create(){
        return inertia('Questions/Create');
    }
    public function store(){
        $newQuestion=request()->validate([
            'title' => "required| min: 5",
            'body' => "required| min: 20"
        ]);
        Auth::user()->questions()->create($newQuestion);
        return redirect('/');
    }
}
