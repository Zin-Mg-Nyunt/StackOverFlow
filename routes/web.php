<?php

use App\Models\Question;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    $questions = Question::with('author')->latest()->get();
    return Inertia::render('Questions/Index', [
        'questions' => $questions
    ]);
})->name('home');

Route::get('/questions/{id}',function($id){
    return inertia('Questions/Detail',[
        'question' => Question::with('author')->findOrFail($id)
    ]);
})->name('questions.detail');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
