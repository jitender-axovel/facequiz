<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Input;

use App\Language;
use App\User;
use App\Quiz;
use App\QuizAttempt;
use App\QuizShare;
use DB;

class AdminController extends Controller
{

    public function getLogin()
    {
    	$page = "Admin Login - Robodoo - Play with Robo";
    	return view('admin.auth.login', compact('page'));
    }

    public function postLogin(Request $request)
    {
    	if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password'), 'user_role_id' => 1])) {
            // Authentication passed...
            return redirect()->intended('admin/dashboard');
        } else {
            $errors = new MessageBag(['email' => ['These credentials do not match our records.']]);
            return back()->withErrors($errors)->withInput(Input::except('password'));
        }
    }

    public function getDashboard()
    {
        $page = 'Dashboard - Robodoo - Play with Robo';

        $overallStats['users'] = User::count();
        $overallStats['quizzes'] = Quiz::count();
        $overallStats['attempts'] = QuizAttempt::count();
        $overallStats['shares'] = QuizShare::count();

        $todayStats['users'] = User::whereRaw('Date(created_at) = Date(NOW())')->count();
        $todayStats['quizzes'] = Quiz::whereRaw('Date(created_at) = Date(NOW())')->count();
        $todayStats['attempts'] = QuizAttempt::whereRaw('Date(created_at) = Date(NOW())')->count();
        $todayStats['shares'] = QuizShare::whereRaw('Date(created_at) = Date(NOW())')->count();

        $lastNDaysActivity = self::lastNDaysRegistrations(30);

        return view('admin.dashboard', compact('page', 'overallStats', 'todayStats', 'lastNDaysActivity'));
    }

    public static function lastNDaysRegistrations($n)
    {
        $activityHistory['users'] = User::select('created_at', DB::raw('count(*) as activityCount'))->where('created_at', '>', DB::raw('DATE_SUB(NOW(), Interval 30 DAY)'))->groupBy('created_at')->get()->toArray();

        $activityHistory['attempts'] = QuizAttempt::select('created_at', DB::raw('count(*) as activityCount'))->where('created_at', '>', DB::raw('DATE_SUB(NOW(), Interval 30 DAY)'))->groupBy('created_at')->get()->toArray();

        $lastNDays = self::lastNDays(30);

        foreach($lastNDays as $key => $day) {
            $lastNDaysActivity[$key] = array('date' => $day, 'users' => 0, 'attempts' => 0);
            foreach($activityHistory['users'] as $activity){
                if (date('Y-m-d', strtotime($activity['created_at'])) === $day) {
                    $lastNDaysActivity[$key]['users'] = $activity['activityCount'];
                }
            }
            foreach($activityHistory['attempts'] as $activity){
                if (date('Y-m-d', strtotime($activity['created_at'])) === $day) {
                    $lastNDaysActivity[$key]['attempts'] = $activity['activityCount'];
                }
            }
        }
        return $lastNDaysActivity;
    }

    // public static function lastNDaysAttempts($n)
    // {
    //     $activityHistory = QuizAttempt::select('created_at', DB::raw('count(*) as activityCount'))->where('created_at', '>', DB::raw('DATE_SUB(NOW(), Interval 30 DAY)'))->groupBy('created_at')->get()->toArray();

    //     $lastNDays = self::lastNDays(30);

    //     foreach($lastNDays as $key => $day) {
    //         $lastNDaysActivity[$key] = array('date' => $day, 'attempts' => 0);
    //         foreach($activityHistory as $activity){
    //             if (date('Y-m-d', time($activity['created_at'])) === $day) {
    //                 $lastNDaysActivity[$key]['attempts'] = $activity['activityCount'];
    //             }
    //         }
    //     }
    //     return $lastNDaysActivity;
    // }

    public static function lastNDays($n){
        $timestamp = time();
        $days = array();
        for ($i = 0 ; $i < $n ; $i++) {
            $days[] = date('Y-m-d', $timestamp);
            $timestamp -= 24 * 3600;
        }
        return $days;
    }

    public function getLanguage(REQUEST $request)
    {
        $page = 'Languages - Admin';
        $languages = Language::get();
        $strings = trans('strings');
        
        return view('admin.languages.index', compact('page', 'languages', 'strings'));
    }

    public function postLanguage(Request $request)
    {
        $page = 'Languages - Robodoo - Play with Robo';
        $languages = Language::get();

        $input = $request->input();
        $language = array_intersect_key($input, Language::$updatable);

        $language['strings'] = json_encode(array_intersect_key($input['strings'], trans('strings')));
        $language = Language::create($language);
        
        return redirect('admin/language')->with('success', 'Language has been saved.');
    }
    
    public function postUpdateLanguage(Request $request, $id)
    {
        $page = 'Languages - Robodoo - Play with Robo';
        $languages = Language::get();

        $input = $request->input();
        $language = array_intersect_key($input, Language::$updatable);

        $language['strings'] = json_encode(array_intersect_key($input['strings'], trans('strings')));
        $language = Language::where('id', $id)->update($language);
        
        return redirect('admin/language')->with('success', 'Language has been saved.');
    }

    public function deleteLanguage($id)
    {
        $language = Language::find($id);
        $name = $language->name;

        if($language->forceDelete()) {
            $result['status'] = true;
            $result['message'] = trim($name)." language has been deleted.";

            return json_encode($result);
        } else {
            $result['status'] = false;
            $result['message'] = $name." language could not deleted.";

            return json_encode($result);
        }
    }
    
    public function getLanguageForm()
    {
        return view('admin.languages.components.new-language-form');
    }
}
