<?php
/**
 * 
 */

namespace App\SC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Season as SeasonModule;

class Season extends SeasonModule
{
  protected $node_type = 'season';

  public function initialize($data=array()) {
    $this->slug = SCHelper::createSlug('seasons');

    return $this;
  }
}
