<?php

namespace PopCode\UserAuth\Managers;

use PopCode\UserAuth\Adapters;
use Illuminate\Auth\AuthManager as BaseAuthManager;

class AuthManager extends BaseAuthManager
{
    protected $manager;

    /**
     * @var \PopCode\UserAuth\Interfaces\AuthAdapterInterface
     */
    protected $adapter;

    protected $user;

    /**
     * @{inheritdoc}
     */
    public function __construct(\Illuminate\Foundation\Application $app) {
        parent::__construct($app);

        $this->manager = \Config::get('popcode-userauth.provider');

        $this->loadAdapter();
    }

    protected function loadAdapter() {
        switch ($this->manager) {
            case 'jwt':
                $this->adapter = new Adapters\JwtAuthAdapter();
                break;
            case 'basic':
            default:
                $this->adapter = new Adapters\BasicAuthAdapter();
                break;
        }
    }

    /**
     * @param array $credentials
     * @param bool|array $additionalData
     *
     * @return bool
     */
    public function attempt($credentials = array(), $additionalData = false) {
        $additionalData = $this->adapter->toValidArgument($additionalData);
        return $this->adapter->attempt($credentials, $additionalData);
    }

    public function user() {
        return $this->adapter->user();
    }

    public function logout() {
        $this->adapter->logout();
    }

    public function authenticate() {
        return (bool)$this->user();
    }


    /**
     * @param $user
     * @param bool|array $additionalData
     *
     * @return string|null
     */
    public function loginAs($user, $additionalData = false) {
        $additionalData = $this->adapter->toValidArgument($additionalData);
        return $this->adapter->loginAs($user, $additionalData);
    }
}
