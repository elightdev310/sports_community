<?php
/**
 * 
 */

namespace App\SC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Division_Team as Division_TeamModule;

class Division_Team extends Division_TeamModule
{
  const STATUS_SEND    = 'send';
  const STATUS_INVITE  = 'invite';
  const STATUS_ACTIVE  = 'active';

  public static function getRecord($team_id, $season_id) {
    $obj = self::where('team_id',     $team_id)
               ->where('season_id',   $season_id)
               ->first();
    return $obj;
  }
}
