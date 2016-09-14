<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Quiz;
use App\Category;
use App\QuizAttempt;
use Auth;
use DB;

class QuizzesController extends Controller
{
    public function index($quizSlug)
    {
        $quiz = Quiz::where('locale', session('locale'))->where('slug', $quizSlug)->where('is_active', 1)->first();

        if(!$quiz) {
            return redirect('/')->with('error', 'Sorry, the quiz you are looking for is unemployed');
        }
        
        $page = $quiz->title . ' - Robodoo - Play With Robo';
        
        $sidebarQuizzeIds = Quiz::where('locale', session('locale'))->where('slug', '!=', $quizSlug)->where('is_active', 1)->take(4)->lists('id');

        $sidebarQuizzes = Quiz::whereIn('id', $sidebarQuizzeIds)->get();

        $quizzes = Quiz::where('locale', session('locale'))->whereNotIn('id', $sidebarQuizzeIds)->where('slug', '!=', $quizSlug)->where('is_active', 1)->get();
        
        return view('quiz.index', compact('page', 'quiz', 'quizzes', 'sidebarQuizzes'));
    }

    public function getPopularQuizzes()
    {
        $page = 'Robodoo - Play With Robo';
        $quizIds = QuizAttempt::distinct()->lists('quiz_id');
        $quizzes = Quiz::where('locale', session('locale'))->where('is_active', 1)->whereIn('id', $quizIds)->where(function ($query) {
                $query->select('quiz_id')->distinct()->from('quiz_attempts')->orderByRaw(DB::raw('total(quiz_id)'));
            })->paginate(12);
        return view('home', compact('quizzes', 'page'));
    }

    public function landing($quizSlug, $userId, $version)
    {
        $quiz = Quiz::where('locale', session('locale'))->where('slug', $quizSlug)->where('is_active', 1)->first();
        
        if(!$quiz) {
            return redirect('/')->with('error', 'Sorry, the quiz you are looking for is unemployed or may be your language is different from quiz language.');
        }

        $page = $quiz->title . ' - Robodoo - Play With Robo';

        $quizAttempt = QuizAttempt::where('quiz_id', $quiz->id)->where('user_id', $userId)->first();

        $sidebarQuizzeIds = Quiz::where('locale', session('locale'))->where('slug', '!=', $quizSlug)->where('is_active', 1)->take(4)->lists('id');

        $sidebarQuizzes = Quiz::whereIn('id', $sidebarQuizzeIds)->get();

        $quizzes = Quiz::where('locale', session('locale'))->whereNotIn('id', $sidebarQuizzeIds)->where('slug', '!=', $quizSlug)->where('is_active', 1)->get();
        
        return view('quiz.landing', compact('page', 'quiz', 'quizzes', 'sidebarQuizzes', 'quizAttempt', 'version'));
    }
    
    public function start($slug, $version)
    {
        if(!(session()->has('fb_access_token'))) {
            auth()->logout();
            return redirect('/')->with('error', 'Kindly try again as your facebook authentication code has expired.');
        }
        $quiz = Quiz::where('locale', session('locale'))->where('slug', $slug)->where('is_active', 1)->first();
        
        if(!$quiz) {
            return redirect('/')->with('error', 'Sorry, the quiz you are looking for is unemployed');
        }
        
        $page = $quiz->title. ' - Robodoo - Play With Robo';
        
        $template = $quiz->template->html_data;
        
        $quizHelper = new \App\QuizHelper();

        //set photos
        $template = $quizHelper->setUserPhotos($template, $quiz);
        
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

        $command = 'ffmpeg -y -i '.$imagePath.'/'.$imageName.' -vf scale=620:-1 '.$imagePath.'/'.$imageName;//dd($command);
        shell_exec($command);

        $quizAttempt = QuizAttempt::where('quiz_id', $quiz->id)->where('user_id', Auth::id())->first();

        if($quizAttempt) {
            $quizAttempt->update(['result_image' => $imageName]);
            $result = $quizAttempt;
        } else {
            $result = QuizAttempt::create([
                'user_id' => Auth::id(),
                'quiz_id' => $quiz->id,
                'result_image' => $imageName
            ]);
        }

        $sidebarQuizzeIds = Quiz::where('locale', session('locale'))->where('slug', '!=', $slug)->where('is_active', 1)->take(4)->lists('id');

        $sidebarQuizzes = Quiz::whereIn('id', $sidebarQuizzeIds)->get();
        
        $quizzes = Quiz::where('locale', session('locale'))->whereNotIn('id', $sidebarQuizzeIds)->where('slug', '!=', $slug)->where('is_active', 1)->get();
        
        return view('quiz.result', compact('page', 'quiz', 'template', 'quizzes', 'sidebarQuizzes', 'result', 'version'));
    }

    public function summary($slug)
    {
        $quiz = Quiz::where('slug', $slug)->first();
        $page = $quiz->title.' - Robodoo - Play with Robo';

        $sidebarQuizzeIds = Quiz::where('locale', session('locale'))->where('slug', '!=', $slug)->where('is_active', 1)->take(4)->lists('id');

        $sidebarQuizzes = Quiz::whereIn('id', $sidebarQuizzeIds)->get();

        $quizzes = Quiz::where('id', '!=', $quiz->id)->where('locale', session('locale'))->whereNotIn('id', $sidebarQuizzeIds)->where('is_active', 1)->orderBy('updated_at', 'DESC')->get();

        return view('quiz.summary', compact('page', 'quiz', 'quizzes', 'sidebarQuizzes'));
    }
}
