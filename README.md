

# LARAVEL INSTALLATION #

run 'composer install popcode/user-auth'

Open up config/app.php and add the following to the providers key.
PopCode\UserAuth\Providers\UserAuthServiceProvider::class,

# CONFIGURATION #
to create default configuration in your config folder run:
php artisan vendor:publish --provider="PopCode\UserAuth\Providers\UserAuthServiceProvider" --tag=config
