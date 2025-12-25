<?php

namespace App\Services;

use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
                            $q->authorized = $q->user_id == Auth::id();
                            return $q;
                        })
                        ->withQueryString();
    }
    public function createQuestion($data){
        return DB::transaction(function() use($data){
            [$allTagsId,$questionData] = $this->getTagIdAndQuestionData($data);
            
            // add user id to question
            $questionData['user_id']=Auth::id();
            if(isset($data['image_url'])){
                $questionData['image_url']=$data['image_url']->store('questions','public');
            }
            $question= Question::create($questionData);
            $question->tags()->sync($allTagsId); //sync tags with question
            return $question;
    });
    }
    public function updateQuestion($question,$data){
        return DB::transaction(function() use($question,$data){
            [$allTagsId,$questionData] = $this->getTagIdAndQuestionData($data);
            // check if image url is set by user
            if(isset($data['image_url'])){
                // check if image url is already set by user in database
                if($question->image_url){
                    // delete old image url
                    Storage::disk('public')->delete($question->getRawOriginal('image_url'));
                }
                // add new image url to question data
                $questionData['image_url']=$data['image_url']->store('questions','public');
            }
            $question->fill($questionData)->save();
            $question->tags()->sync($allTagsId); //sync tags with question
            return $question;
        });
    }
    public function getTagIdAndQuestionData($data){
        $allTagsId=collect($data['tags'])->map(function($tag){
            return Tag::firstOrCreate(
                ['slug'=>Str::slug($tag['name'],'-')],
                ['name'=>$tag['name']]
            )->id;
        });
        $questionData = collect($data)->except('tags')->toArray();
        return [$allTagsId,$questionData];
    }
    public function getAnswers($question){
        return $question->answers()
                    ->with(['votes'=> fn($v)=> $v->where("user_id",Auth::id()) ]) // use eager to query builder before loop
                    ->withCount('upvotes','downvotes')
                    ->when(request('sort') === 'latest', function($query){$query->latest();})
                    ->paginate(3)
                    ->through(function($answer){
                        // this cause N+1 problem because use query in loop
                        // $anser['userVote'] = $answer->votes()->where('user_id',Auth::id())->first()?->value;
                        $answer['userVote'] = $answer->votes->first()?->value; // reduce N+1 problem
                        unset($answer->votes); // remove vote list before send data to client-side
                        return $answer;
                    })
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
