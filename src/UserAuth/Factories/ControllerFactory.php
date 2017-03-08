<?php

namespace PopCode\UserAuth\Factories;

class ControllerFactory
{
    protected $provider;

    protected $controller;

    public function __construct($forcedProvider = null) {

        if ($forcedProvider) {
            $this->provider = $forcedProvider;
        } else {
            $this->provider = \Config::get('popcode-userauth.provider', 'basic');
        }

        $this->bootUp();
    }

    public function getController() {
        return $this->controller;
    }

    protected function bootUp() {
        $className = \Config::get('popcode-userauth.providers.class');
        $this->controller = new $className;
    }

}
