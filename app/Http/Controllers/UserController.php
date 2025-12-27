<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;

class UserController extends Controller
{
    public function show(User $user, UserService $userService)
    {     
        // Calculate reputation (simplified: votes from questions)
        // $reputation = $user->questions()->sum('votes') ?? 0;
        $reputation = 0;

        // Calculate total views from questions
        // $views = $user->questions()->sum('views') ?? 0;
        $views = 0;

        return inertia('User/Profile', [
            'profileUser' => $userService->getUser($user),
            'stats' => [
                'reputation' => $reputation,
                'questions' => $user->questions_count,
                'answers' => $user->answers_count,
                'savedQuestions' => $user->saved_questions_count,
                'views' => $views,
            ],
            'questions' => $userService->getQuestions($user),
            'savedQuestions' => $userService->getSavedQuestions($user),
            'answers' => $userService->getAnswers($user),
            'state' => request('state'),
        ]);
    }
}
