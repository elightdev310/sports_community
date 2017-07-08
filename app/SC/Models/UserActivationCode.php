<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\SC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\UserActivationCode as UserActivationCodeModule;

class UserActivationCode extends UserActivationCodeModule
{
    public function user() {
        return $this->hasOne('App\SC\Models\User', 'user_id');
    }
}
