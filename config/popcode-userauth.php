<?php

return [
    'register_default_routes'   => false,

    'messages'                  => [
        'invalid_login' => 'Invalid username or password!',
    ],

    // basic|jwt
    'provider'                  => 'jwt',

    'token_cookie_name'         => false,

    'url'                       => [
        'refresh-token'         => '/refresh-token',
        'login'                 => '/admin/login',
    ],

    'providers'                 => [
        'basic'   => [
            'class'   => PopCode\UserAuth\Controllers\UserAuthController::class,
        ],
        'user'    => [
            'adapter' => PopCode\UserAuth\Adapters\EloquentUserAdapter::class,
        ],
        'jwt'     => [
            'adapter' => PopCode\UserAuth\Adapters\JWTNamshiAdapter::class,
        ],
        'auth'    => [
            'adapter' => PopCode\UserAuth\Adapters\IlluminateAuthAdapter::class,
        ],
        'storage' => [
            'adapter' => PopCode\UserAuth\Adapters\IlluminateCacheAdapter::class,
        ],
    ],

];
