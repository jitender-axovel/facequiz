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

class AdminController extends Controller
{

    public function getLogin()
    {
    	$page = "Admin";
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
        $page = 'Dashboard - Admin';

        $overallStats['users'] = User::count();
        $overallStats['quizzes'] = Quiz::count();
        $overallStats['attempts'] = QuizAttempt::count();
        $overallStats['shares'] = QuizShare::count();

        $todayStats['users'] = User::where('created_at', date('Y-m-d'))->count();
        $todayStats['quizzes'] = Quiz::where('created_at', date('Y-m-d'))->count();
        $todayStats['attempts'] = QuizAttempt::where('created_at', date('Y-m-d'))->count();
        $todayStats['shares'] = QuizShare::where('created_at', date('Y-m-d'))->count();

        return view('admin.dashboard', compact('page', 'overallStats', 'todayStats'));
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
        $page = 'Languages - Admin';
        $languages = Language::get();

        $input = $request->input();
        $language = array_intersect_key($input, Language::$updatable);

        $language['strings'] = json_encode(array_intersect_key($input, trans('strings')));
        $language = Language::create($language);
        
        return redirect('admin/language')->with('success', 'Language has been saved.');
    }
    
    public function postUpdateLanguage(Request $request, $id)
    {
        $page = 'Languages - Admin';
        $languages = Language::get();

        $input = $request->input();
        $language = array_intersect_key($input, Language::$updatable);

        $language['strings'] = json_encode(array_intersect_key($input, trans('strings')));
        $language = Language::where('id', $id)->update($language);
        
        return redirect('admin/language')->with('success', 'Language has been saved.');
    }
    
    public function getLanguageForm()
    {
        return view('admin.languages.components.new-language-form');
    }
}
