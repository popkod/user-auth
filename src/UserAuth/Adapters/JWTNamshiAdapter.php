<?php

namespace PopCode\UserAuth\Adapters;

use Tymon\JWTAuth\Providers\JWT\NamshiAdapter;

class JWTNamshiAdapter extends NamshiAdapter
{
    /**
     * @{inheritdoc}}
     */
    public function __construct($secret, $algo, $driver = null) {
        parent::__construct($secret, $algo, $driver);
    }

    /**
     * @{inheritdoc}
     */
    public function encode(array $payload) {
        return parent::encode($payload);
    }

    /**
     * @{inheritdoc}
     */
    public function decode($token)
    {
        return parent::decode($token);
    }
}
