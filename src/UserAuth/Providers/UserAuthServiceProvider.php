<?php

namespace PopCode\UserAuth\Providers;

use Illuminate\Support\ServiceProvider;
use Config;

class UserAuthServiceProvider extends ServiceProvider
{
    protected $root;

    public function boot() {

        $root = __DIR__ . '/../../../';

        if (Config::get('popcode-userauth.register_default_routes')) {
            // register routes
            $this->loadRoutesFrom($root . 'routes/popcode-userauth-routes.php');
        }

        // merge configuration
        $this->mergeConfigFrom($root . 'config/popcode-userauth.php', 'popcode-userauth');

    }
}
