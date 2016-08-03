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
        $page = 'Robodoo';
        $quizzes = Quiz::where('is_active', 1)->orderBy('updated_at', 'DESC')->paginate(12);
        return view('home', compact('quizzes', 'page'));
    }
}
