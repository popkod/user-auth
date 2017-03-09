<?php

namespace PopCode\UserAuth\Adapters;

use Tymon\JWTAuth\Providers\User\EloquentUserAdapter as TymonEloquentUserAdapter;
use Illuminate\Database\Eloquent\Model;


class EloquentUserAdapter extends TymonEloquentUserAdapter
{
    /**
     * @{inheritdoc}
     */
    public function __construct(Model $user)
    {
        parent::__construct($user);
    }

    /**
     * @{inheritdoc}
     */
    public function getBy($key, $value)
    {
        return parent::getBy($key, $value);
    }
}
