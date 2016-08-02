<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Quiz;
use App\Category;
use App\QuizAttempt;
use Auth;

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

        $filePath = public_path('files/');

        if (!file_exists($filePath)) {
            mkdir($filePath, 0777, true);
        }

        $fileName = md5(time()).'.html';

        $imagePath = config('image.quiz_result_path');

        if(!file_exists($imagePath)) {
            mkdir($imagePath, 0777, true);
        }

        $imageName = md5(time()).'.png';

        $myfile = fopen($filePath.$fileName, "w+") or die("Unable to open file!");
        chmod($filePath.$fileName, 0777);
        fwrite($myfile, htmlspecialchars_decode($template));
        fclose($myfile);
        $command = 'xvfb-run wkhtmltoimage ' . $filePath.'/'.$fileName . ' '. $imagePath.'/'.$imageName;
        shell_exec($command);

        $result = QuizAttempt::create([
            'user_id' => Auth::id(),
            'quiz_id' => $quiz->id,
            'result_image' => $imageName
            ]);

        
        $quizzes = Quiz::where('slug', '!=', $slug)->where('is_active', 1)->get();
        
        return view('quiz.result', compact('page', 'quiz', 'template', 'quizzes', 'result'));
    }
}
