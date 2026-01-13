<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Tag;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        
        $tags =  [
            [
                "name"=>"PHP",
                "slug"=>"php"
            ],
            [
                "name"=>"JavaScript",
                "slug"=>"javascript"
            ],
            [
                "name"=>"Laravel",
                "slug"=>"laravel"
            ],
            [
                "name"=>"InertiaJs",
                "slug"=>"inertiajs"
            ],
            [
                "name"=>"Vue",
                "slug"=>"vue"
            ],
        ];
        foreach ($tags as $tag) {
            Tag::factory()->create([
                "name"=>$tag['name'],
                "slug"=>$tag['slug']
            ]);
        }

        $users=User::factory(5)->create();
        $users->each(function($user) use($users){
            $questions=Question::factory(5)->create(['user_id'=>$user->id]);
            $questions->each(function($question) use($users){
                $userIds = $users->where('id','!=',$question->user_id)->pluck('id');
                $count = min($userIds->count(),2);
                $userIds = $userIds->random($count);
                $userIds->each(function($userId) use($question){
                    Answer::factory(rand(1,2))->create([
                        'question_id'=>$question->id,
                        'user_id'=>$userId
                    ]);
                });
                $question->tags()->attach(Tag::inRandomOrder()->take(rand(1,3))->pluck('id'));
            });
        });
    }
}
