<?php
/**
 * 
 */

namespace App\SC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Team_Member as Team_MemberModule;

class Team_Member extends Team_MemberModule
{
    const STATUS_SEND    = 'send';
    const STATUS_INVITE  = 'invite';
    const STATUS_ACTIVE  = 'active';

    public static function getRecord($team_id, $user_id) {
      $obj = self::where('team_id', $team_id)
                 ->where('user_id', $user_id)
                 ->first();
      return $obj;
    }
}
