

# INSTALLATION #

run `composer install popcode/user-auth`

Open up config/app.php and add the following to the providers key.
`PopCode\UserAuth\Providers\UserAuthServiceProvider::class`,

# CONFIGURATION #
to create default configuration in your config folder run:
`php artisan vendor:publish --provider="PopCode\UserAuth\Providers\UserAuthServiceProvider" --tag=config`

to put the required migrations into their right place run
`php artisan vendor:publish --provider="PopCode\UserAuth\Providers\UserAuthServiceProvider" --tag=migrations`
then call
`php artisan migrate`


if you use JWT see it's documentation here:
https://github.com/tymondesigns/jwt-auth/wiki


the service provider and aliases for JWT auth are automatically registered you only shoul call
`php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\JWTAuthServiceProvider"`
`php artisan jwt:generate`

In `app\Http\Kernel.php` add
`'pcauth' => \PopCode\UserAuth\Middlewares\Authenticate::class,`
to the routeMiddleware array

add the social service credentials to your config/services.php file like
    `'facebook' => [
        'client_id' => env('FB_CLIENT_ID'),
        'client_secret' => env('FB_CLIENT_SECRET'),
        'redirect' => env('APP_URL') . '/login/fb-callback',
    ],`


# DEV TOOLS #
barryvdh/laravel-ide-helper package added to the dev dependencies
to generate helpers just run:
`php artisan ide-helper:generate && php artisan ide-helper:meta && php artisan ide-helper:models --nowrite`



<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1730102350583634',
      cookie     : true,
      xfbml      : true,
      version    : 'v2.8'
    });
    FB.AppEvents.logPageView();   
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
