<?php

namespace PopCode\UserAuth\Adapters;

use Auth;
use PopCode\UserAuth\Interfaces\AuthAdapterInterface;

class BasicAuthAdapter implements AuthAdapterInterface
{
    public function attempt($credentials, $remember = false) {
        return Auth::attempt($credentials, $remember);
    }

    public function user() {
        if ($user = Auth::user()) {
            return $user;
        }

        // check other gurads
        foreach (array_keys(\Config::get('auth.guards', [])) as $guard) {
            if ($user = Auth::guard($guard)->user()) {
                return $user;
            }
        }

        return null;
    }

    public function logout() {
        Auth::logout();
    }

    public function loginAs($user, $remember = false) {
        Auth::login($user, $remember);
        return null;
    }

    public function toValidArgument($arg) {
        return is_bool($arg) ? $arg : false;
    }
}
