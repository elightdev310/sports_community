<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\SC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\UserProfile as UserProfileModule;

class UserProfile extends UserProfileModule
{
    public function user() {
        return $this->belongsTo('App\SC\Models\User');
    }

    public function coverPhotoPath() {
      if ($this->cover_photo_id) {
        if ($cover_photo = Photo::find($this->cover_photo_id)) {
          return $cover_photo->path();
        }
      }
      return false;
    }
}
