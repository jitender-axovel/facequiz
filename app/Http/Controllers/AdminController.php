<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Input;

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
        return view('admin.dashboard', compact('page'));
    }
}
