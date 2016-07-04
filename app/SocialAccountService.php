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
            return $account;
        } else {

            $user = User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {

                $deletedUser = User::onlyTrashed()->whereEmail($providerUser->getEmail())->first();

                if($deletedUser) {
                    return 2;
                }
                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                    'user_role_id' => 3,
                ]);
            }

            return $user;

        }

    }
}