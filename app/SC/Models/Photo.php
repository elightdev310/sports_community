<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\SC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Photo as PhotoModule;

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
}
