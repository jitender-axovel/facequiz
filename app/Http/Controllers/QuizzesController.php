<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Quiz;
use App\Category;

class QuizzesController extends Controller
{
    public function index($quizSlug)
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
        
        $page = $quiz->title;
        
        $template = $quiz->template->html_data;
        
        $quizHelper = new \App\QuizHelper();
        
        //set title of quiz
        $template = $quizHelper->setTitle($template, $quiz);

        //set background image for quiz
        $template = $quizHelper->setBackgroundImage($template, $quiz);
        
        //set user profile image
        $template = $quizHelper->setUserProfileImage($template, $quiz);
        
        //set user name
        $template = $quizHelper->setUserName($template, $quiz);
        
        //set friends data
        $template = $quizHelper->setFriendData($template, $quiz);
        
        //set facts
        $template = $quizHelper->setFacts($template, $quiz);
        
        $quizzes = Quiz::where('slug', '!=', $slug)->where('is_active', 1)->get();
        
        return view('quiz.result', compact('page', 'quiz', 'template', 'quizzes'));
    }
}
