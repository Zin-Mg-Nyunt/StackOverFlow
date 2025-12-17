<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Support\Facades\Auth;


class QuestionController extends Controller
{
    public function index(){
        cache()->forget('randomQuestions');
        return inertia('Questions/Index', [
            'filters' => request(['search','tag']),
            'questions' => Question::filter(request(['search','tag']))->latest()->get(),
        ]);
    }
    public function show(Question $question){
        return inertia('Questions/Detail',[
            'question' => $question->load('answers.author'),
            'relatedQuestions' => $this->getRandomQuestions(),
        ]);
    }
    public function getRandomQuestions(){
        return cache()->remember("randomQuestions",now()->addMinutes(2),function(){
            return Question::inRandomOrder()->take(3)->get();
        });
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
