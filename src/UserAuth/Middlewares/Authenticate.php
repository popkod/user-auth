<?php

namespace PopCode\UserAuth\Middlewares;

use Closure;
use Illuminate\Auth\AuthenticationException;
use PCAuth;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;

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
            return $this->errorResponseGenerator($guards);
        } catch (AuthenticationException $e) {
            return $this->errorResponseGenerator($guards);
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

    protected function errorResponseGenerator($props) {
        return response('', 401);
    }
}
