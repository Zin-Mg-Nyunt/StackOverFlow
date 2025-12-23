<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Services\QuestionService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
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
            'slug' => "required| unique:questions",
            'body' => "required| min: 20",
            'tags' => "required | array | min:1 | max:5",
            'image_url' => "nullable | image | mimes:jpeg,png,jpg,gif,svg | max:2048",
        ]);
        
        // create question and sync tags
        $newQuestion=$questionService->createQuestion($newQuestion);
        return redirect()->route('questions.detail', $newQuestion->slug)->with('success','Question created successfully');
    }
    public function destroy(Question $question){
        Gate::authorize('delete',$question);
        $question->delete();
        return redirect()->route('home')->with('success','Question deleted successfully');
    }
    public function edit(Question $question){
        if (Gate::denies('update',$question)) {
            return redirect()->back()->with('danger','You are not authorized to edit this question');
        }
        return inertia('Questions/QuestionForm',[
            'question' => $question,
        ]);
    }
    public function update(Question $question, QuestionService $questionService){
        Gate::authorize('update',$question);
        $updateQuestion=request()->validate([
            'title' => "required| min: 5",
            'slug' => ['required',Rule::unique('questions')->ignore($question->id)],
            'body' => "required| min: 20",
            'tags' => "required | array | min:1 | max:5",
            'image_url' => "nullable | image | mimes:jpeg,png,jpg,gif,svg | max:2048",
        ]);
        $updatedQuestion=$questionService->updateQuestion($question,$updateQuestion);
        return redirect()->route('questions.detail', $updatedQuestion->slug)->with('success','Question updated successfully');
    }
}
