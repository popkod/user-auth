<?php

namespace PopCode\UserAuth\Controllers;

use Illuminate\Routing\Controller as BaseController;
use PopCode\UserAuth\Interfaces\UserAuthControllerInterface;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends BaseController implements UserAuthControllerInterface
{
    public function __construct() {

    }

    public function login() {
        if (Auth::attempt(['email' => \Request::get('email'), 'password' => \Request::get('password')])) {
            $user = Auth::user();
            return $this->responseGenerator($user, 'login');
        } else {
            return $this->errorResponseGenerator(
                \Request::all(),
                ['message' => 'Hibás felhasználónév vagy jelszó'],
                'login'
            );
        }
    }

    public function logout() {
        Auth::logout();
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
