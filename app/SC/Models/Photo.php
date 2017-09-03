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
    public function file() {
      if ($this->file_id) {
        return $this->belongsTo('App\Models\Upload', 'file_id');
      }
      return false;
    }

    public function group() {
      return $this->belongsTo('App\SC\Models\Node', 'group_nid');
    }

    public function remove() {
      if (file_exists($this->file->path)) {
        unlink( $this->file->path );
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
