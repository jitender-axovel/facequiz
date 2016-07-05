<?php

namespace App;

use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService
{
    public function createOrGetUser(ProviderUser $providerUser)
    {
        $account = User::whereEmail($providerUser->getEmail())->first();

        if($account && $account->is_blocked == 1) {
            return 3;
        }

        if ($account) {
            $account->name = $providerUser->getName();
            $account->avatar = $providerUser->getAvatar();
            $account->gender = ($providerUser->user['gender']=='male' ? 'M' : 'F');
            $account->save();
            return $account;
        } else {

            $user = User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {

                $deletedUser = User::onlyTrashed()->whereEmail($providerUser->getEmail())->first();

                if($deletedUser) {
                    return 2;
                }
                $user = User::create([
                    'fb_id' => $providerUser->getId(),
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                    'avatar' => $providerUser->getAvatar(),
                    'gender' => ($providerUser->user['gender']=='male' ? 'M' : 'F'),
                    'user_role_id' => 3,
                ]);
            }

            return $user;

        }

    }
}