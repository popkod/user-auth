<?php

namespace PopCode\UserAuth\Adapters;

use Tymon\JWTAuth\Providers\Auth\IlluminateAuthAdapter as TymonIlluminateAuthAdapter;
use Illuminate\Auth\AuthManager;

class IlluminateAuthAdapter extends TymonIlluminateAuthAdapter
{
    /**
     * @{inheritdoc}
     */
    public function __construct(AuthManager $auth)
    {
        parent::__construct($auth);
    }

    /**
     * @{inheritdoc}
     */
    public function byCredentials(array $credentials = [])
    {
        return parent::byCredentials($credentials);
    }

    /**
     * @{inheritdoc}
     */
    public function byId($id)
    {
        return parent::byId($id);
    }

    /**
     * @{inheritdoc}
     */
    public function user()
    {
        return parent::user();
    }
}
