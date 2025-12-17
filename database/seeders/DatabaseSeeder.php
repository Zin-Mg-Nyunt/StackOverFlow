<?php

namespace Database\Seeders;

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

        User::factory(5)
            ->has(Question::factory()->count(5))
            ->create();
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
            Tag::create([
                "name"=>$tag['name'],
                "slug"=>$tag['slug']
            ]);
        }
    }
}
