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

    public function getCurrent() {
        $user = PCAuth::user();
        return $this->responseGenerator($user, 'me');
    }


    public function fbRedirect() {
        return Socialite::driver('facebook')->stateless()->redirect();
    }

    public function fbCallback(SocialAccountService $service) {
        if (\Request::get('error')) {
            return $this->errorResponseGenerator('', \Request::all());
        };

        $providerUser = Socialite::driver('facebook')->stateless()->user();


        $user = $service->createOrGetUser($providerUser);

        PCAuth::loginAs($user);

        return $this->responseGenerator(PCAuth::user(), 'fb-login');
    }

    public function refreshToken() {
        if (PCAuth::refreshToken()) {
            if (\Request::ajax() || \Request::wantsJson()) {
                return $this->getCurrent();
            }
            if (\Request::get('redirect-after')) {
                return redirect(\Request::get('redirect-after'));
            }
            return $this->responseGenerator($this->getCurrent());
        }

        if (!\Request::ajax() && !\Request::wantsJson() && $redirectTo = \Config::get('popcode-userauth.url.login')) {
            return redirect($redirectTo);
        }

        return $this->errorResponseGenerator([], [], null, 401);
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
