<?php

namespace PopCode\UserAuth\Middlewares;

use Closure;
use Illuminate\Auth\AuthenticationException;
use PCAuth;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class Authenticate
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        try {
            $this->authenticate($guards);
        } catch (TokenBlacklistedException $e) {
            return $this->errorResponseGenerator(false, $guards);
        } catch (AuthenticationException $e) {
            return $this->errorResponseGenerator(false, $guards);
        } catch (TokenExpiredException $e) {
            return $this->errorResponseGenerator(true, $guards);
        }

        return $next($request);
    }

    /**
     * Determine if the user is logged in to any of the given guards.
     *
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function authenticate(array $guards)
    {
        if (PCAuth::authenticate()) {
            return;
        }

        throw new AuthenticationException('Unauthenticated.', $guards);
    }

    protected function errorResponseGenerator($expired, $props) {
        if ($expired) {
            if (\Request::ajax() || \Request::wantsJson()) {
                return response()->json(['expired' => true]);
            } elseif ($redirectTo = \Config::get('popcode-userauth.url.refresh-token')) {
                return redirect($redirectTo);
            }
        }
        if (\Request::ajax() || \Request::wantsJson()) {
            return response('', 401);
        }
        if ($redirectTo = \Config::get('popcode-userauth.url.login')) {
            return redirect($redirectTo, 303);
        }
        return redirect('/');
    }
}
