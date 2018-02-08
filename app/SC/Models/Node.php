<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\SC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Node as NodeModule;

use SCNodeLib;

class Node extends NodeModule
{
    public function user() {
        return $this->belongsTo('App\SC\Models\User');
    }

    public function getField($field, $default_value='') {
      return SCNodeLib::getNodeField($this->id, $field, $default_value);
    }
    public function saveField($field, $value) {
      return SCNodeLib::saveNodeField($this->id, $field, $value);
    }
    
}
