<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Quiz;
use App\Category;

class QuizzesController extends Controller
{
    public function index($categorySlug, $quizSlug)
    {
        $quiz = Quiz::where('slug', $quizSlug)->where('is_active', 1)->first();
        
        $page = $quiz->title . ' - FaceQuiz';
        
        if(!$quiz) {
            return redirect('/')->with('error', 'Sorry, the quiz you are looking for is unemployed');
        }
        
        $quizzes = Quiz::where('slug', '!=', $quizSlug)->where('is_active', 1)->get();
        
        return view('quiz.index', compact('page', 'quiz', 'quizzes'));
    }
    
    public function start($slug)
    {
        $quiz = Quiz::where('slug', $slug)->where('is_active', 1)->first();
        if(!$quiz) {
            return redirect('/')->with('error', 'Sorry, the quiz you are looking for is unemployed');
        }
        
        $quizzes = Quiz::where('slug', '!=', $slug)->where('is_active', 1)->get();
    }
}
