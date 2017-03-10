<?php

namespace PopCode\UserAuth\Controllers;

use PCAuth;
use Socialite;
use PopCode\UserAuth\Services\SocialAccountService;
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


    public function fbRedirect() {
        return Socialite::driver('facebook')->stateless()->redirect();
    }

    public function fbCallback(SocialAccountService $service) {
        $providerUser = Socialite::driver('facebook')->stateless()->user();

        $user = $service->createOrGetUser($providerUser);

        auth()->login($user);

        return redirect()->to('/home');
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
