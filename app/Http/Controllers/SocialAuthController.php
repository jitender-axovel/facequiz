<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;
use App\SocialAccountService;
use Socialite;

class SocialAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();   
    }   

    public function callback(SocialAccountService $service)
    {
        // when facebook call us a with token   
        $user = $service->createOrGetUser(Socialite::driver('facebook')->user());

        if(is_int($user) && $user == 2) {
            return redirect('/')->with('error', 'Dear user, your account has been deleted by admin earlier. Kindly create a new account if you want to user our services.');
        } elseif(is_int($user) && $user == 3) {
            return redirect('/')->with('error', 'Dear user, your account has been blocked by admin. Kindly write to support if you want to discuss any details.');
        }

        auth()->login($user);

        return redirect('/');
    }
}