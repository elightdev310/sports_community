<?php
/**
 * 
 */

namespace App\SC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\League_Member as League_MemberModule;

class League_Member extends League_MemberModule
{
    const STATUS_SEND    = 'send';
    const STATUS_INVITE  = 'invite';
    const STATUS_ACTIVE  = 'active';

    public static function getRecord($league_id, $user_id) {
      $obj = self::where('league_id', $league_id)
                 ->where('user_id', $user_id)
                 ->first();
      return $obj;
    }
}
