<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\SC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User as UserModule;
use App\SC\Models\Node;
use SCPostLib;

class User extends UserModule
{
    use SoftDeletes;

    public function profile() {
      return $this->hasOne('App\SC\Models\UserProfile');
    }

    public function createProfile() {
      $profile = new UserProfile;
      $profile->user_id = $this->id;
      $profile->save();
    }

    public function getNode() {
      $node = Node::where('object_id', '=', $this->id)
                  ->where('type', '=', 'user')
                  ->first();
      if (!$node) {
        $node = Node::create([
            'object_id'   => $this->id, 
            'type'        => 'user', 
            'user_id'     => $this->id
        ]);
      }
      return $node;
    }

    public function getPosts() {
      return SCPostLib::getPosts($this->getNode());
    }
}
