<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\OtpVerifyController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

Route::middleware('loginUser')->group(function(){
    Route::get('/questions/ask',[QuestionController::class, 'create'])->name('questions.create'); 
    Route::post('/questions/{question:slug}/save',[QuestionController::class, 'save'])->name('question.save'); // via router
    Route::post('/vote',[VoteController::class, 'toggle'])->name('vote.store'); // via router
    Route::post('/like',[LikeController::class, 'toggle'])->name('like.toggle'); // via axios
    Route::post('/questions/{question}/answer/store',[AnswerController::class, 'store'])->name('answer.store'); // via axios
    Route::get('/users/{user}/profile',[UserController::class, 'show'])->name('user.profile');
});

Route::get('/', [QuestionController::class, 'index'])->name('home');
Route::get('/questions/{question:slug}',[QuestionController::class, 'show'])->name('questions.detail');
Route::post('/questions/store',[QuestionController::class, 'store'])->name('questions.store');
Route::get('/questions/{question:slug}/edit',[QuestionController::class, 'edit'])->name('question.edit');
Route::put('/questions/{question:slug}/update',[QuestionController::class, 'update'])->name('question.update');
Route::delete('/questions/{question}/delete',[QuestionController::class, 'destroy'])->name('question.delete');



Route::get('/answers/{answer}/replies',[AnswerController::class, 'replies'])->name('answer.replies');

// overwrite route to fortify controller
Route::get('/forgot-password',[ForgotPasswordController::class,'create'])->name('password.request');
Route::post('/forgot-password',[ForgotPasswordController::class,'store'])->name('password.email');
Route::post('/forgot-password/changeEmail',[ForgotPasswordController::class,'change'])->name('password.changeEmail');
Route::post('otp-verify',[OtpVerifyController::class,'verify'])->name('otp.verify');
Route::get('reset-password/{token}',[ResetPasswordController::class,'create'])->name('password.reset');
Route::post('reset-password',[ResetPasswordController::class,'store'])->name('password.update');

// update profile
Route::post('/users/{user}/profile/update',[ProfileController::class,'update'])->name('update.profile');
require __DIR__.'/settings.php';