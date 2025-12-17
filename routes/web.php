<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [QuestionController::class, 'index'])->name('home');
Route::get('/questions/ask',[QuestionController::class, 'create'])->name('questions.create')->middleware('loginUser');
Route::post('/questions/store',[QuestionController::class, 'store'])->name('questions.store');
Route::get('/questions/{question}',[QuestionController::class, 'show'])->name('questions.detail');
Route::post('/questions/{question}/answer/store',[AnswerController::class, 'store'])->name('answer.store');


require __DIR__.'/settings.php';
