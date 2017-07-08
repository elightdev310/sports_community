<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\SC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\SocialProfile as SocialProfileModule;

class SocialProfile extends SocialProfileModule
{
    public function user() {
        return $this->hasOne('App\SC\Models\User', 'email', 'email');
    }
}
