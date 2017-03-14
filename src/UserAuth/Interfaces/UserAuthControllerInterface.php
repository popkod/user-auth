<?php

namespace PopCode\UserAuth\Interfaces;

interface UserAuthControllerInterface
{
    public function __construct();

    public function login();

    public function logout();

    public function refreshToken();
}
