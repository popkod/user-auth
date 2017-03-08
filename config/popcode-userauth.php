<?php

return [
    'register_default_routes' => false,

    'messages' => [
        'invalid-login' => 'Invalid username or password!',
    ],

    'provider' => '',

    'providers' => [
        'basic' => [
            'class' => PopCode\UserAuth\Controllers\UserAuthController::class,
        ]
    ],
];
