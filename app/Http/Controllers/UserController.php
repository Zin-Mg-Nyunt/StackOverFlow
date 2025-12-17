<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function show(User $user)
    {
        $user->loadCount([
            'questions',
            'answers',
        ]);

        $questions = $user->questions()
            ->withCount(['answers'])
            ->latest()
            ->take(10)
            ->get();

        $answers = $user->answers()
            ->with(['question'])
            ->latest()
            ->take(10)
            ->get();

        // Calculate reputation (simplified: votes from questions)
        // $reputation = $user->questions()->sum('votes') ?? 0;
        $reputation = 0;

        // Calculate total views from questions
        // $views = $user->questions()->sum('views') ?? 0;
        $views = 0;

        return inertia('User/Profile', [
            'user' => $user,
            'stats' => [
                'reputation' => $reputation,
                'questions' => $user->questions_count,
                'answers' => $user->answers_count,
                'views' => $views,
            ],
            'questions' => $questions,
            'answers' => $answers,
        ]);
    }
}
