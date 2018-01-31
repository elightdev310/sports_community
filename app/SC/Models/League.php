<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\SC\Models;

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
}
