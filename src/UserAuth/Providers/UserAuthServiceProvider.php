<?php

namespace PopCode\UserAuth\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\SocialiteServiceProvider;
use PopCode\UserAuth\Controllers\PCUserAuthController as UserAuthController;
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

        $datePrefix = \Carbon\Carbon::now()->format('Y_m_d_His');

        if (!class_exists('CreateSocialAccountsTable')) {
            $this->publishes(
                [
                    $root . 'migrations/2017_03_10_144855_create_social_accounts_table.php' => database_path('migrations/' . $datePrefix . '_create_social_accounts_table.php'),
                ],
                'migrations'
            );
        }

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

        // Socialite
        $this->app->register(SocialiteServiceProvider::class);
        $loader->alias('Socialite', Socialite::class);
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
