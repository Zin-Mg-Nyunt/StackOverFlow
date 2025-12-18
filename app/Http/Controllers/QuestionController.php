<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Services\QuestionService;


class QuestionController extends Controller
{
    public function index(){
        return inertia('Questions/Index', [
            'filters' => request(['search','tag']),
            'questions' => Question::withCount("answers")->filter(request(['search','tag']))->latest()->get(),
        ]);
    }
    public function show(Question $question){
        $sort = request('sort');
        $answers = $question->answers()
                    ->when($sort === 'latest', function($query){$query->latest();})
                    ->paginate(3)
                    ->withQueryString();
                    
        return inertia('Questions/Detail',[
            'question' => $question,
            'answers' => $answers,
            'sort' => $sort,
            'relatedQuestions' => $this->getRandomQuestions($question),
        ]);
    }
    public function getRandomQuestions($question){
        if ($question->tags->isEmpty()) {
            return [];
        }
        return cache()->remember("randomQuestions_".$question->id,now()->addMinute(),function() use($question){
            $tags=$question->tags->pluck('name');
            return Question::whereHas('tags',function($query) use($tags){
                $query->whereIn('name',$tags);
            })->where('id','!=',$question->id)->get()->random(3);
        });
    }
    public function create(){
        return inertia('Questions/Create');
    }
    public function store(QuestionService $questionService){
        $newQuestion=request()->validate([
            'title' => "required| min: 5",
            'body' => "required| min: 20"
        ]);
        $newQuestion=$questionService->createQuestion($newQuestion);
        return redirect()->route('questions.detail', $newQuestion->id);
    }
}
