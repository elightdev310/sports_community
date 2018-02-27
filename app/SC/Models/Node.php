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
    
    public function coverPhotoPath($size=0) {
      $cover_photo_id = $this->getField(NodeField::FIELD_COVER_PHOTO_ID, 0);
      if ($cover_photo_id) {
        if ($cover_photo = Photo::find($cover_photo_id)) {
          if ($size) {
            return $cover_photo->path($size);
          } else {
            return $cover_photo->path();
          }
        }
      }
      return false;
    }
    
}
