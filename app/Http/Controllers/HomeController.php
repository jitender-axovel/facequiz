<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\Quiz;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = 'Robodoo - Play With Robo';
        $quizzes = Quiz::where('locale', session('locale'))->where('is_active', 1)->orderBy('updated_at', 'DESC')->paginate(12);
        return view('home', compact('quizzes', 'page'));
    }

    public function revokePermissions()
    {
        if(!(session()->has('fb_access_token'))) {
            auth()->logout();
            return redirect('/')->with('error', 'Kindly try again as your facebook authentication code has expired.');
        }

        $quizHelper = new \App\QuizHelper();

        if($quizHelper->revokePermissions()['success'] == true) {
            auth()->logout();
            return redirect('/')->with('success', 'App permissions have been revoked successfully.');
        } else {
            return redirect('/')->with('error', 'App permissions could not be revoked.');
        }
    }
}
