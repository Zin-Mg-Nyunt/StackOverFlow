<?php

use App\Http\Controllers\QuestionController;
use App\Models\Question;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', [QuestionController::class, 'index'])->name('home');

Route::get('/questions/{id}',function($id){
    return inertia('Questions/Detail',[
        'question' => Question::findOrFail($id)
    ]);
})->name('questions.detail');

// Route::get('dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
