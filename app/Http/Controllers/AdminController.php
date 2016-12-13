<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Input;
use Khill\Lavacharts\Lavacharts;

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

        $todayStats['users'] = User::whereRaw("Date(CONVERT_TZ(FROM_UNIXTIME(`created_at`), @@session.time_zone, '+00:00')) = Date(UTC_TIMESTAMP())")->count();
        $todayStats['quizzes'] = Quiz::whereRaw("Date(CONVERT_TZ(FROM_UNIXTIME(`created_at`), @@session.time_zone, '+00:00')) = Date(UTC_TIMESTAMP())")->count();
        $todayStats['attempts'] = QuizAttempt::whereRaw("Date(CONVERT_TZ(FROM_UNIXTIME(`created_at`), @@session.time_zone, '+00:00')) = Date(UTC_TIMESTAMP())")->count();
        $todayStats['shares'] = QuizShare::whereRaw("Date(CONVERT_TZ(FROM_UNIXTIME(`created_at`), @@session.time_zone, '+00:00')) = Date(UTC_TIMESTAMP())")->count();

        $lastNDaysActivity = self::lastNDaysRegistrations(30);

        $lava = new LavaCharts();
        $temperatures = $lava->DataTable('UTC');

        $temperatures->addDateColumn('Date')
                     ->addNumberColumn('User Registrations')
                     ->addNumberColumn('Quiz Attempts');

        foreach ($lastNDaysActivity as $activity) {
            $temperatures->addRow([$activity['date'], $activity['users'], $activity['attempts']]);
        }

        $lava->LineChart('Temps', $temperatures, [
            'title' => 'Graph Analysis'
        ]);

        return view('admin.dashboard', compact('page', 'overallStats', 'todayStats', 'lastNDaysActivity', 'lava'));
    }

    public static function lastNDaysRegistrations($n)
    {
        $activityHistory['users'] = User::select(DB::raw("DATE(CONVERT_TZ(created_at, @@session.time_zone, '+00:00')) as created_at"), DB::raw('count(*) as activityCount'))->where('created_at', '>', DB::raw('DATE_SUB(NOW(), Interval 30 DAY)'))->groupBy('created_at')->get()->toArray();

        $activityHistory['attempts'] = QuizAttempt::select(DB::raw("DATE(CONVERT_TZ(created_at, @@session.time_zone, '+00:00')) as created_at"), DB::raw('count(*) as activityCount'))->where('created_at', '>', DB::raw('DATE_SUB(NOW(), Interval 30 DAY)'))->groupBy('created_at')->get()->toArray();

        $lastNDays = self::lastNDays(30);

        foreach($lastNDays as $key => $day) {
            $lastNDaysActivity[$key] = array('date' => $day, 'users' => 0, 'attempts' => 0);
            foreach($activityHistory['users'] as $activity){
                if (date('Y-m-d', strtotime($activity['created_at'])) == $day && $activity['activityCount'] == 1) {
                    $lastNDaysActivity[$key]['users'] = ++$lastNDaysActivity[$key]['users'];
                }
            }
            foreach($activityHistory['attempts'] as $activity){
                if (date('Y-m-d', strtotime($activity['created_at'])) == $day && $activity['activityCount'] == 1) {
                    $lastNDaysActivity[$key]['attempts'] = ++$lastNDaysActivity[$key]['attempts'];
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
        $languages = Language::orderBy('order', 'ASC')->get();
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
        $language['order'] = (Language::get()->count() + 1);
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

    public function changeLanguageOrder($id, $status)
    {
        $language = Language::find($id);
        if (($status == 'up' && $language->order == 1) || ($status == 'down' && $language->order == Language::get()->count())) {
            //do nothing
        } else {
            switch ($status) {
                case 'up':
                    Language::where('order', $language->order-1)->increment('order', '1');
                    $language->order = --$language->order;
                    $language->save();
                    break;
                
                case 'down':
                    Language::where('order', $language->order+1)->decrement('order', '1');
                    $language->order = ++$language->order;
                    $language->save();
                    break;

                default:
                    # code...
                    break;
            }
        }

        $languages = Language::orderBy('order', 'ASC')->get();
        return view('admin.languages.language-list', compact('languages'));
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
