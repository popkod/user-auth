<?php

namespace PopCode\UserAuth\Adapters;

use JWTAuth;
use PopCode\UserAuth\Interfaces\AuthAdapterInterface;

class JwtAuthAdapter implements AuthAdapterInterface
{
    protected $user;

    protected $token;

    public function __construct() {
        $this->checkIfTokenProvided();
    }

    public function attempt($credentials, $customCredentials = []) {
        if ($token = JWTAuth::attempt($credentials, $customCredentials)) {
            $this->setUserObject($token);
            return true;
        }
        return false;
    }

    public function user() {
        if (!$this->user) {
            $this->checkIfTokenProvided();
        }
        return $this->user;
    }

    public function logout() {
        \Session::remove('jwt-token');
        JWTAuth::invalidate($this->token);
    }

    public function loginAs($user, $customCredentials = []) {
        $this->user = $user;
        $this->setUserObject(JWTAuth::fromUser($user, $customCredentials ?: []));
        return null;
    }

    public function toValidArgument($arg) {
        return is_array($arg) ? $arg : [];
    }

    protected function checkIfTokenProvided() {
        if ($token = JWTAuth::getToken()) {
            $this->setUserObject($token);
            return;
        }

        if ($token = \Session::get('jwt-token')) {
            $this->setUserObject($token);
            return;
        }

        if ($cookieName = \Config::get('popcode-userauth.token_cookie_name')) {
            if ($token = \Request::cookie($cookieName)) {
                $this->setUserObject($token);
                return;
            }
        }
    }


    protected function setUserObject($token) {
        $this->token = $token;
        $user = JWTAuth::toUser($token);

        if ($user) {
            $this->user = $user;
            $this->user->token = $token;
            \Session::put('jwt-token', $user->token);
        }
    }
}
