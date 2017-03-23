<?php

namespace PopCode\UserAuth\Services;

use PopCode\UserAuth\Models\SocialAccount;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService
{
    protected $existed = false;

    public function createOrGetUser(ProviderUser $providerUser) {
        $userModel = \Config::get('popcode-usercrud.model');
        /* @var \PopCode\UserAuth\Models\User $userModel */
        $userModel = new $userModel;
        $account = SocialAccount::where('provider', '=', 'facebook')
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account) {
            $this->existed = true;
            return $account->user;
        } else {
            $this->existed = false;

            $account = new SocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => 'facebook'
            ]);

            $user = $userModel->where('email', '=', $providerUser->getEmail())->first();

            if (!$user) {
                $user = $userModel->newInstance([
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                ]);
                $user->save();
            } else {
                $this->existed = true;
            }

            $account->user()->associate($user);
            $account->save();

            return $user;
        }
    }

    public function isNew() {
        return !$this->existed;
    }
}
