<?php

namespace PopCode\UserAuth\Models;

use PopCode\UserCrud\Models\User as BaseUser;

class User extends BaseUser
{
    public function socialAccounts() {
        return $this->hasMany(SocialAccount::class);
    }

    public function delete() {
        $this->socialAccounts()->delete();
        return parent::delete();
    }
}
