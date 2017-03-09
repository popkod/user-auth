<?php

namespace PopCode\UserAuth\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use PopCode\UserAuth\Controllers\UserAuthController;
use PopCode\UserAuth\Managers\AuthManager;
use Tymon\JWTAuth\Providers\JWTAuthServiceProvider;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
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
    }

    public function register() {

        $root = __DIR__ . '/../../../';

        // merge configuration
        $this->mergeConfigFrom($root . 'config/popcode-userauth.php', 'popcode-userauth');

        $this->app->bind('UserAuth', function() {
            return new UserAuthController;
        });

        $this->app->bind('popcode-authmanager', AuthManager::class);

        $this->setDefaultConfig();

        $this->register3rdParties();
    }

    protected function register3rdParties() {
        $loader = AliasLoader::getInstance();

        // JWT
        $this->app->register(JWTAuthServiceProvider::class);
        $loader->alias('JWTAuth',    JWTAuth::class);
        $loader->alias('JWTFactory', JWTFactory::class);
    }

    /**
     * Override configuration on 3rd party dependencies
     */
    protected function setDefaultConfig() {
        Config::set('jwt.user',              Config::get('popcode-usercrud.model'));
        Config::set('jwt.providers.user',    Config::get('popcode-userauth.providers.user.adapter'));
        Config::set('jwt.providers.jwt',     Config::get('popcode-userauth.providers.jwt.adapter'));
        Config::set('jwt.providers.auth',    Config::get('popcode-userauth.providers.auth.adapter'));
        Config::set('jwt.providers.storage', Config::get('popcode-userauth.providers.storage.adapter'));
    }
}
