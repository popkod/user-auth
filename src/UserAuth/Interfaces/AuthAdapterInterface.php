<?php

namespace PopCode\UserAuth\Interfaces;

interface AuthAdapterInterface
{
    public function attempt($credentials, $additionalData);

    public function user();

    public function logout();

    public function loginAs($user, $additionalData);

    public function toValidArgument($arg);
}
