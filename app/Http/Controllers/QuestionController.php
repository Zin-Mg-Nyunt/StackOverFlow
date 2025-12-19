<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Services\QuestionService;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class QuestionController extends Controller
{
    public function index(QuestionService $questionService){
        return inertia('Questions/Index', [
            'filters' => request(['search','tag']),
            'questions' => Inertia::scroll($questionService->getQuestions()),
        ]);
    }
    public function show(Question $question, QuestionService $questionService){
        return inertia('Questions/Detail',[
            'question' => $question,
            'answers' => $questionService->getAnswers($question),
            'sort' => request('sort'),
            'relatedQuestions' => $questionService->getRelatedQuestions($question),
        ]);
    }
    public function create(){
        return inertia('Questions/QuestionForm');
    }
    public function store(QuestionService $questionService){
        $newQuestion=request()->validate([
            'title' => "required| min: 5",
            'body' => "required| min: 20"
        ]);
        $newQuestion=$questionService->createQuestion($newQuestion);
        return redirect()->route('questions.detail', $newQuestion->id);
    }
    public function destroy(Question $question){
        Gate::authorize('delete',$question);
        $question->delete();
        return redirect()->route('home');
    }
    public function edit(Question $question){
        Gate::authorize('update',$question);
        return inertia('Questions/QuestionForm',[
            'question' => $question,
        ]);
    }
    public function update(Question $question){
        Gate::authorize('update',$question);
        $updateQuestion=request()->validate([
            'title' => "required| min: 5",
            'body' => "required| min: 20"
        ]);
        $question->update($updateQuestion);
        return redirect()->route('questions.detail', $question->id);
    }
}
