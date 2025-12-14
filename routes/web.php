<?php

use App\Http\Controllers\QuestionController;
use App\Models\Question;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', [QuestionController::class, 'index'])->name('home');
Route::get('/questions/ask',[QuestionController::class, 'create'])->name('questions.create')->middleware('loginUser');
Route::post('/questions/store',[QuestionController::class, 'store'])->name('questions.store');
Route::get('/questions/{question}',[QuestionController::class, 'show'])->name('questions.detail');


require __DIR__.'/settings.php';
