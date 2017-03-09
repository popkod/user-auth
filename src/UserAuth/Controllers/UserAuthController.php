<?php

namespace PopCode\UserAuth\Controllers;

use PCAuth;
use Illuminate\Routing\Controller as BaseController;
use PopCode\UserAuth\Interfaces\UserAuthControllerInterface;

class UserAuthController extends BaseController implements UserAuthControllerInterface
{
    public function __construct() {

    }

    public function login() {
        if (PCAuth::attempt(['email' => \Request::get('email'), 'password' => \Request::get('password')])) {
            $user = PCAuth::user();
            return $this->responseGenerator($user, 'login');
        } else {
            return $this->errorResponseGenerator(
                \Request::all(),
                \Config::get('popcode-userauth.messages.invalid_login'),
                'login'
            );
        }
    }

    public function logout() {
        PCAuth::logout();

        return $this->responseGenerator(['logout' => 'success'], 'logout');
    }


    protected function responseGenerator($responseData, $type = null) {
        if (\Request::ajax() || \Request::wantsJson()) {
            return response()->json($responseData);
        }

        // TODO return view by type
        return $responseData;
    }

    protected function errorResponseGenerator($data, $messages, $type = null, $status = 400) {
        if (\Request::ajax() || \Request::wantsJson()) {
            return response()->json(['error' => $messages], $status);
        }

        // TODO return view by type
        return $messages;
    }
}
