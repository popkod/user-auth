

# INSTALLATION #

run `composer install popcode/user-auth`

Open up config/app.php and add the following to the providers key.
`PopCode\UserAuth\Providers\UserAuthServiceProvider::class`,

# CONFIGURATION #
to create default configuration in your config folder run:
`php artisan vendor:publish --provider="PopCode\UserAuth\Providers\UserAuthServiceProvider" --tag=config`


if you use JWT see it's documentation here:
https://github.com/tymondesigns/jwt-auth/wiki


the service provider and aliases for JWT auth are automatically registered you only shoul call
`php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\JWTAuthServiceProvider"`
`php artisan jwt:generate`

In `app\Http\Kernel.php` add
`'pcauth' => \PopCode\UserAuth\Middlewares\Authenticate::class,`
to the routeMiddleware array

# DEV TOOLS #
barryvdh/laravel-ide-helper package added to the dev dependencies
to generate helpers just run:
`php artisan ide-helper:generate && php artisan ide-helper:meta && php artisan ide-helper:models --nowrite`
