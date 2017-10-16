<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\SC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Photo as PhotoModule;
use SCPhotoLib;

class Photo extends PhotoModule
{
    public function group() {
      return $this->belongsTo('App\SC\Models\Node', 'group_nid');
    }

    public function remove() {
      if (file_exists($this->path())) {
        unlink( $this->path() );
      }
      $this->forceDelete();
    }

    public function author() {
        return $this->belongsTo('App\SC\Models\User', 'user_id');
    }

    public function path($thumb_size=0) {
      return SCPhotoLib::getThumbPhotoUrl($this, $thumb_size);
    }
}
