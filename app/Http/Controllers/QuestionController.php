<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Services\QuestionService;
use Inertia\Inertia;

class QuestionController extends Controller
{
    public function index(){
        return inertia('Questions/Index', [
            'filters' => request(['search','tag']),
            'questions' => Inertia::scroll(Question::withCount("answers")->filter(request(['search','tag']))->latest()->paginate(10)),
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
            'relatedQuestions' => $this->getRelatedQuestions($question),
        ]);
    }
    public function getRelatedQuestions($question){
        return cache()->remember("relatedQuestions_".$question->id,now()->addMinute(),function() use($question){
            // if no tags, get latest questions
            if ($question->tags->isEmpty()) {
                return $this->getLatestQuestions($question);
            }
            // if has tags, get questions with same tags
            $tags=$question->tags->pluck('name');
            $result = Question::whereHas('tags',function($query) use($tags){
                $query->whereIn('name',$tags);
            })->where('id','!=',$question->id)->inRandomOrder()->limit(3)->get();
            // if no result, get latest questions
            if($result->isEmpty()){
                $result = $this->getLatestQuestions($question);
            }elseif ($result->count() <3) {
                $needed = 3 - $result->count();
                Question::where('id','!=',$question->id)
                        ->whereNotIn('id',$result->pluck('id')) //exclude already related questions
                        ->latest()
                        ->limit($needed)
                        ->get()
                        ->merge($result); //merge with existing results
            }
            return $result;
        });
    }
    public function getLatestQuestions($question){
        return Question::where('id','!=',$question->id)
                ->latest()
                ->limit(3)
                ->get();
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
