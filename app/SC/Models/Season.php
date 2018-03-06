<?php
/**
 * 
 */

namespace App\SC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Season as SeasonModule;

use SCNodeLib;
use SCUserLib;
use SCHelper;

class Season extends SeasonModule
{
  const TABLE_NAME = 'seasons';
  const NODE_TYPE  = 'season';
  
  public function initialize($data=array()) {
    $currentUser = SCUserLib::currentUser();

    // $this->slug = SCHelper::createSlug($this->name, self::TABLE_NAME);
    // $this->save();
    
    $node = Node::create([
        'object_id'   => $this->id, 
        'type'        => self::NODE_TYPE, 
        'user_id'     => $currentUser->id, 
    ]);
    return $this;
  }

  public function getNode() {
    return SCNodeLib::getNode($this->id, self::NODE_TYPE);
  }

  public function league() {
    return $this->belongsTo('App\SC\Models\League');
  }
}
