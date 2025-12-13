<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(){
            return inertia('Questions/Index', [
                'questions' => Question::filter(request(['search']))->latest()->get()
            ]);
    }
}
