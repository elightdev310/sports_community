<?php
/**
 * 
 */

namespace App\SC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Season as SeasonModule;

use SCNodeLib;
use SCHelper;

class Season extends SeasonModule
{
  protected $node_type = 'season';
  
  public function initialize($data=array()) {
    // $this->slug = SCHelper::createSlug($this->name, self::TABLE_NAME);
    // $this->save();
    
    $node = Node::create([
        'object_id'   => $this->id, 
        'type'        => self::NODE_TYPE, 
        'user_id'     => $this->creator_uid, 
    ]);
    return $this;
  }

  public function getNode() {
    return SCNodeLib::getNode($this->id, self::NODE_TYPE);
  }
}
