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
  protected $node_type = 'league';

  public function initialize($data=array()) {
    $this->slug = SCHelper::createSlug($this->name, 'leagues');
    $this->save();
    
    $node = Node::create([
        'object_id'   => $this->id, 
        'type'        => $this->node_type, 
        'user_id'     => $this->creator_uid, 
    ]);
    return $this;
  }
  public function getNode() {
    $node = Node::where('object_id', '=', $this->id)
                ->where('type', '=', $this->node_type)
                ->first();
    return $node;
  }

}
