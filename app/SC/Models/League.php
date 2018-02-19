<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\SC\Models;

use DB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\League as LeagueModule;

use SCHelper;

class League extends LeagueModule
{
  const TABLE_NAME = 'leagues';
  const NODE_TYPE  = 'league';

  public function initialize($data=array()) {
    $this->slug = SCHelper::createSlug($this->name, self::TABLE_NAME);
    $this->save();
    
    $node = Node::create([
        'object_id'   => $this->id, 
        'type'        => self::NODE_TYPE, 
        'user_id'     => $this->creator_uid, 
    ]);
    return $this;
  }
  public function getNode() {
    $node = Node::where('object_id', '=', $this->id)
                ->where('type', '=', self::NODE_TYPE)
                ->first();
    return $node;
  }
  public static function getLeague($slug) {
    $league_id = SCHelper::getObjectIDBySlug($slug, self::TABLE_NAME);
    if ($league_id) {
      return self::find($league_id);
    }
    return null;
  }

  /**
   * get URL of cover photo
   */
  public function coverPhotoPath() {
    $node = $this->getNode();
    if ($node) {
      $cover_photo_id = $node->getField(NodeField::FIELD_COVER_PHOTO_ID, 0);
      if ($cover_photo_id) {
        if ($cover_photo = Photo::find($cover_photo_id)) {
          return $cover_photo->path();
        }
      }
    }
    return false;
  }

  /**
   * Get Members
   */
  public function members() {
    $members = DB::table('users')
              ->select('users.*')
              ->rightJoin('league_members AS lm', 'users.id', '=', 'lm.user_id')
              ->where('lm.league_id', $this->id)
              ->where('lm.active', 1)
              ->orderBy('lm.created_at', 'ASC')
              ->get();
    return $members;
  }

  /**
   * Get Join Requests
   */
  public function getJoinRequests() {
    $requests = DB::table('users')
              ->select('users.*')
              ->addSelect('lm.status AS status')
              ->rightJoin('league_members AS lm', 'users.id', '=', 'lm.user_id')
              ->where('lm.league_id', $this->id)
              ->where('lm.active', 0)
              ->where('lm.status', '<>', '')
              ->orderBy('lm.created_at', 'ASC')
              ->get();
    return $requests;
  }
}
