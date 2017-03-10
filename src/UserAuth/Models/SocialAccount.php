<?php

namespace PopCode\UserAuth\Models;

use Config;
use Illuminate\Database\Eloquent\Model as Eloquent;

class SocialAccount extends Eloquent
{

    public $table = 'social_accounts';

    protected $fillable = [
        'user_id',
        'provider_user_id',
        'provider',
    ];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
    ];

    public function user() {
        return $this->belongsTo(Config::get('popcode-usercrud.model'));
    }
}
