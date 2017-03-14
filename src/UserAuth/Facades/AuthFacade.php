<?php

namespace PopCode\UserAuth\Facades;

use Illuminate\Support\Facades\Facade;
use PopCode\UserAuth\Managers\AuthManager;

class AuthFacade extends Facade
{
    /**
     * Get the binding in the IoC container
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'popcode-authmanager'; // the IoC binding.
    }
}
