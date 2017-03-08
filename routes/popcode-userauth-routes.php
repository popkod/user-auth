<?php

Illuminate\Support\Facades\Route::post(
    '/api/login',
    '\\PopCode\\UserAuth\\Controllers\\UserAuthController@login'
);
Illuminate\Support\Facades\Route::post(
    '/api/logout',
    '\\PopCode\\UserAuth\\Controllers\\UserAuthController@logout'
);
