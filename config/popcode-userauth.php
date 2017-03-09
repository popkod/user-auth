<?php

return [
    'register_default_routes'   => false,

    'messages'                  => [
        'invalid-login' => 'Invalid username or password!',
    ],

    'provider'                  => '',

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

    // set the above configuration to the 3rd party packages
    'override-3rd-party-config' => true,
];
