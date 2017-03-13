<?php
/**
 * API routes
 */
Route::post(
    '/api/login',
    '\\PopCode\\UserAuth\\Controllers\\UserAuthController@login'
);
Route::any(
    '/api/logout',
    '\\PopCode\\UserAuth\\Controllers\\UserAuthController@logout'
);

Route::get(
    '/api/users/me',
    '\\PopCode\\UserAuth\\Controllers\\UserAuthController@getCurrent'
)->middleware('pcauth');

/**
 * Social routes
 */
Route::get(
    '/login/fb',
    '\\PopCode\\UserAuth\\Controllers\\UserAuthController@fbRedirect'
);

Route::get(
    '/login/fb-callback',
    '\\PopCode\\UserAuth\\Controllers\\UserAuthController@fbCallback'
);
