<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

Route::middleware('loginUser')->group(function(){
    Route::get('/questions/ask',[QuestionController::class, 'create'])->name('questions.create');
    Route::post('/questions/{question:slug}/save',[QuestionController::class, 'save'])->name('question.save');
    Route::post('/vote',[VoteController::class, 'toggle'])->name('vote.store');
    Route::post('/like',[LikeController::class, 'toggle'])->name('like.toggle');
});

Route::get('/', [QuestionController::class, 'index'])->name('home');
Route::get('/questions/{question:slug}',[QuestionController::class, 'show'])->name('questions.detail');
Route::post('/questions/store',[QuestionController::class, 'store'])->name('questions.store');
Route::get('/questions/{question:slug}/edit',[QuestionController::class, 'edit'])->name('question.edit');
Route::put('/questions/{question:slug}/update',[QuestionController::class, 'update'])->name('question.update');
Route::delete('/questions/{question}/delete',[QuestionController::class, 'destroy'])->name('question.delete');

Route::post('/questions/{question}/answer/store',[AnswerController::class, 'store'])->name('answer.store');

Route::get('/users/{user}/profile',[UserController::class, 'show'])->name('user.profile');

Route::get('/answers/{answer}/replies',[AnswerController::class, 'replies'])->name('answer.replies');

require __DIR__.'/settings.php';