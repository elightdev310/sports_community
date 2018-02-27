<?php
/**
 * 
 */

namespace App\SC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\League_Team as League_TeamModule;

class League_Team extends League_TeamModule
{
    const STATUS_SEND    = 'send';
    const STATUS_INVITE  = 'invite';
    const STATUS_ACTIVE  = 'active';

    public static function getRecord($league_id, $team_id) {
      $obj = self::where('league_id', $league_id)
                 ->where('team_id', $team_id)
                 ->first();
      return $obj;
    }
}
