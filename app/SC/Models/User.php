<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\SC\Models;

use DB;

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

    public function getFriendIDs() {
      $u1 = DB::table('friendships')->select('user1_id as uid')->where('user2_id', '=', $this->id)->get();
      $u2 = DB::table('friendships')->select('user2_id as uid')->where('user1_id', '=', $this->id)->get();
      $u = array_merge($u1, $u2);
      $data = array();
      foreach ($u as $row) {
        $data[$row->uid] = $row->uid;
      }
      return $data;
    }
}
