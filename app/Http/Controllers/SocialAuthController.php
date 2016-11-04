<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;
use App\SocialAccountService;
use Socialite;
use URL;

class SocialAuthController extends Controller
{
    public function redirect(Request $request)
    {
        return Socialite::driver('facebook')->scopes(['email', 'user_likes', 'user_birthday', 'user_friends', 'user_photos', 'user_posts'])->redirect();   
    }   

    public function callback(Request $request, SocialAccountService $service)
    {
        // if user denies pemissions
        if($request->input('error') == 'access_denied' && $request->input('error_code') == 200) {
            return redirect('/')->with('error', 'Whoops, looks like you denied permissions for this app.');
        }

        // when facebook call us a with token   
        $user = $service->createOrGetUser(Socialite::driver('facebook')->user());

        if(is_int($user) && $user == 2) {
            return redirect('/')->with('error', 'Dear user, your account has been deleted by admin earlier. Kindly create a new account if you want to use our services.');
        } elseif(is_int($user) && $user == 3) {
            return redirect('/')->with('error', 'Dear user, your account has been blocked by admin. Kindly write to support if you want to discuss any details.');
        } elseif(is_int($user) && $user == 4) {
            return redirect('/')->with('error', 'Dear User, please provide your email id to enjoy diffrent quizzes. Else we would be unable to create your account.');
        }

        auth()->login($user);
        if(session('redirect_url')) {
            $redirectUrl = session('redirect_url');
            $request->session()->forget('redirect_url');
            return redirect($redirectUrl);
        }
        return redirect('/');
    }
}
