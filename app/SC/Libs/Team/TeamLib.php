<?php

namespace App\SC\Libs\Team;

use DB;
use Auth;
use Mail;

use Exception;

use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;
use Dwij\Laraadmin\Helpers\LAHelper;

use App\Role;
use App\SC\Models\User;
use App\SC\Models\Team;
use App\SC\Models\Team_Member;
use App\SC\Models\League_Team;

use SCUserLib;
use SCHelper;

class TeamLib 
{
  /**
   * Laravel application
   *
   * @var \Illuminate\Foundation\Application
   */
  public $app;

  /**
   * Create a new confide instance.
   *
   * @param \Illuminate\Foundation\Application $app
   *
   * @return void
   */
  public function __construct($app)
  {
    $this->app = $app;
  }

  /**
   * Create team 
   * @param  $data: array(name, creator_uid)
   */
  public function createTeam($data=array()) {
    // TODO: check duplication of team name
    $team = Team::create([
        'name'        => $data['name'], 
        'creator_uid' => $data['creator_uid'], 
    ]);

    if ($team) {
      $team = $team->initialize();
    }

    return $team;
  }
  public function checkTeamExist($name) {
    $count = Team::where('name', $name)->count();
    if ($count) { return true; }
    return false;
  }

  /**
   * search team
   */
  public function searchTeam($term) {
    $currentUser = SCUserLib::currentUser();

    //$teams = Team::where('name', 'LIKE', '%'.$term.'%')->get();
    $query = "SELECT t.*, tm.active, tm.status 
              FROM teams AS t 
              LEFT JOIN team_members AS tm 
                    ON t.id=tm.team_id AND tm.user_id=? 
              WHERE t.name LIKE ?";
    $teams = DB::select($query, array($currentUser->id, '%'.$term.'%'));

    return $teams;
  }


  //////////////////////////////////////////////////////////////////////////////
  /// Team Member
  //////////////////////////////////////////////////////////////////////////////
  public function isTeamMember($user_id, $team_id) {
    $tm_record = Team_Member::getRecord($team_id, $user_id);
    if ($tm_record && $tm_record->active) {
      return true;
    }
    return false;
  }

  /**
   * Sent Request to Team
   */
  public function sentRequestTeamMember($user_id, $team_id) {
    $tm_record = Team_Member::getRecord($team_id, $user_id);
    if ($tm_record) {
      if ($tm_record->active) {
        return 10;    // Already Member
      } else {
        $tm_record->status = Team_Member::STATUS_SEND;
        $tm_record->save();
        return 1;   // OK
      }
    } else {
      $tm_record = Team_Member::create(array(
        'team_id' => $team_id,
        'user_id' => $user_id, 
        'active'  => 0,
        'status'  => Team_Member::STATUS_SEND
      ));
      if ($tm_record) {
        return 1;   // OK
      }
    }
    return false;
  }
  public function cancelRequestTeamMember($user_id, $team_id) {
    $tm_record = Team_Member::getRecord($team_id, $user_id);
    if ($tm_record) {
      if ($tm_record->active) {
        return 10;    // Already Member
      } else {
        $tm_record->status = '';
        $tm_record->save();
        return 1;   // OK
      }
    }
    return 1;
  }
  public function allowTeamMember($user_id, $team_id) {
    $tm_record = Team_Member::getRecord($team_id, $user_id);
    if ($tm_record) {
      if ($tm_record->active) {
        return 10;    // Already Member
      } else if ($tm_record->status==Team_Member::STATUS_SEND) {
        $tm_record->status = Team_Member::STATUS_ACTIVE;
        $tm_record->active = 1;
        $tm_record->save();
        return 1;   // OK
      } else {
        return 11;  
      }
    } else {
      $tm_record = Team_Member::create(array(
        'team_id' => $team_id,
        'user_id' => $user_id, 
        'active'  => 1,
        'status'  => Team_Member::STATUS_ACTIVE
      ));
      if ($tm_record) {
        return 1;   // OK
      }
    }
    return false;
  }

  public function leaveTeamMember($user_id, $team_id) {
    $tm_record = Team_Member::getRecord($team_id, $user_id);
    if ($tm_record) {
      if ($tm_record->active) {
        $tm_record->status = '';
        $tm_record->active = 0;
        $tm_record->save();
        return true;
      }
    }
    return true;
  }

  public function isTeamManager($user_id, $team) {
    if ($team->creator_uid == $user_id) {
      return true;
    }
    return false;
  }

  /////////////////////////////////////////////////////////////////////////////

  /**
   * Sent Request to League Team
   */
  public function sentRequestLeagueTeam($team_id, $league_id) {
    $lt_record = League_Team::getRecord($league_id, $team_id);
    if ($lt_record) {
      if ($lt_record->active) {
        return 10;    // Already League Team
      } else {
        $lt_record->status = League_Team::STATUS_SEND;
        $lt_record->save();
        return 1;   // OK
      }
    } else {
      $lt_record = League_Team::create(array(
        'league_id' => $league_id, 
        'team_id'   => $team_id,
        'active'    => 0,
        'status'    => League_Team::STATUS_SEND
      ));
      if ($lt_record) {
        return 1;   // OK
      }
    }
    return false;
  }
  public function cancelRequestLeagueTeam($team_id, $league_id) {
    $lt_record = League_Team::getRecord($league_id, $team_id);
    if ($lt_record) {
      if ($lt_record->active) {
        return 10;    // Already Member
      } else {
        $lt_record->status = '';
        $lt_record->save();
        return 1;   // OK
      }
    }
    return 1;
  }
  public function allowLeagueTeam($team_id, $league_id) {
    $lt_record = League_Team::getRecord($league_id, $team_id);
    if ($lt_record) {
      if ($lt_record->active) {
        return 10;    // Already Member
      } else if ($lt_record->status==League_Team::STATUS_SEND) {
        $lt_record->status = League_Team::STATUS_ACTIVE;
        $lt_record->active = 1;
        $lt_record->save();
        return 1;   // OK
      } else {
        return 11;  
      }
    } else {
      $lt_record = League_Team::create(array(
        'league_id' => $league_id,
        'team_id'   => $team_id,
        'active'    => 1,
        'status'    => League_Team::STATUS_ACTIVE
      ));
      if ($lt_record) {
        return 1;   // OK
      }
    }
    return false;
  }

  public function leaveLeagueTeam($team_id, $league_id) {
    $lt_record = League_Team::getRecord($league_id, $team_id);
    if ($lt_record) {
      if ($lt_record->active) {
        $lt_record->status = '';
        $lt_record->active = 0;
        $lt_record->save();
        return true;
      }
    }
    return true;
  }
}
