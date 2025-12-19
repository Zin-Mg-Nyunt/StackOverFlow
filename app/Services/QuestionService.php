<?php

namespace App\Services;

use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class QuestionService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function getQuestions(){
        return Question::withCount("answers")
                        ->filter(request(['search','tag']))
                        ->latest()
                        ->paginate(10)
                        ->through(function($q){
                            $q->authorized = $q->user_id == auth()->id();
                            return $q;
                        })
                        ->withQueryString();
    }
    public function createQuestion($data){
        $data['user_id']=Auth::id();
        return Question::create($data);
    }
    public function getAnswers($question){
        return $question->answers()
                    ->when(request('sort') === 'latest', function($query){$query->latest();})
                    ->paginate(3)
                    ->withQueryString();
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
}
