<?php

namespace PopCode\UserAuth\Providers;

use Illuminate\Support\ServiceProvider;
use PopCode\UserAuth;
use Config;

class UserAuthServiceProvider extends ServiceProvider
{
    protected $root;

    public function boot() {

        $root = __DIR__ . '/../../../';

        // enable create configuration
        $this->publishes(
            [
                $root . 'config/popcode-userauth.php' => config_path('popcode-userauth.php'),
            ],
            'config'
        );

        if (Config::get('popcode-userauth.register_default_routes')) {
            // register routes
            $this->loadRoutesFrom($root . 'routes/popcode-userauth-routes.php');
        }

        // merge configuration
        $this->mergeConfigFrom($root . 'config/popcode-userauth.php', 'popcode-userauth');

    }

    public function register() {
        $this->app->bind('UserAuth', function() {
            return new UserAuth\Controllers\UserAuthController;
        });

        // TODO register JWT
    }
}
