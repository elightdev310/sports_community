<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\SC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User as UserModule;

class User extends UserModule
{
    use SoftDeletes;

    public function profile() {
      return $this->hasOne('App\SC\Models\UserProfile', 'user_id');
    }

    public function createProfile() {
      $profile = new UserProfile;
      $profile->user_id = $this->id;
      $profile->save();
    }
}
