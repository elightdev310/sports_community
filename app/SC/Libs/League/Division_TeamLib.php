<?php

namespace App\SC\Libs\League;

use DB;
use Auth;
use Mail;

use Exception;

use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;
use Dwij\Laraadmin\Helpers\LAHelper;

use App\Role;
use App\SC\Models\User;
use App\SC\Models\Season;
use App\SC\Models\Team;
use App\SC\Models\Division_Team;

use SCHelper;

class Division_TeamLib 
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
   * Get Division Teams By User
   *
   * @return void
   */
  public function getDivisionTeamsByUserTeams($user_id, $season_id) {
    $query = "SELECT t.*, dt.active, dt.status 
              FROM teams AS t 
              LEFT JOIN division_teams AS dt 
                    ON (t.id=dt.team_id) 
              WHERE t.creator_uid = ? AND 
                    (dt.season_id = ? OR dt.season_id IS NULL)";
    $dt_teams = DB::select($query, array($user_id, $season_id));
    return $dt_teams;
  }
  public function getDivisionTeamsByUser($user_id, $season_id) {
    $query = "SELECT t.*, dt.active, dt.status 
              FROM teams AS t 
              LEFT JOIN division_teams AS dt 
                    ON (t.id=dt.team_id) 
              WHERE t.creator_uid = ? AND 
                    (dt.season_id = ? AND dt.status<>'')";
    $dt_teams = DB::select($query, array($user_id, $season_id));
    return $dt_teams;
  }

  /**
   * Send request for team to join season
   */
  public function sendRequestDivisionTeam(Team $team, Season $season) {
    $dt_record = Division_Team::getRecord($team->id, $season->id);
    if ($dt_record) {
      if ($dt_record->active) {
        return 10;    // Already Joined
      } else {
        $dt_record->status = Division_Team::STATUS_SEND;
        $dt_record->save();
        return 1;   // OK
      }
    } else {
      $dt_record = Division_Team::create(array(
        'team_name'   => $team->name, 
        'division_id' => 0, 
        'team_id'     => $team->id, 
        'season_id'   => $season->id, 
        'active'      => 0,
        'status'      => Division_Team::STATUS_SEND
      ));
      if ($dt_record) {
        return 1;   // OK
      }
    }
    return false;
  }
  public function cancelRequestDivisionTeam(Team $team, Season $season) {
    $dt_record = Division_Team::getRecord($team->id, $season->id);
    if ($dt_record) {
      if ($dt_record->active) {
        return 10;    // Already Joined
      } else {
        $dt_record->status = '';
        $dt_record->save();
        return 1;   // OK
      }
    } 
    return 0;
  }
  public function allowRequestDivisionTeam(Team $team, Season $season) {
    $dt_record = Division_Team::getRecord($team->id, $season->id);
    if ($dt_record) {
      if ($dt_record->active) {
        return 10;    // Already Member
      } else if($dt_record->status==Division_Team::STATUS_SEND) {
        $dt_record->status = Division_Team::STATUS_ACTIVE;
        $dt_record->active = 1;
        $dt_record->save();
        return 1;   // OK
      } else {
        return 11;
      }
    }
    return false;
  }
  public function rejectRequestDivisionTeam(Team $team, Season $season) {
    $dt_record = Division_Team::getRecord($team->id, $season->id);
    if ($dt_record) {
      if ($dt_record->active) {
        return 10;    // Already Joined
      } else {
        $dt_record->status = '';
        $dt_record->save();
        return 1;   // OK
      }
    } 
    return 0;
  }

  public function leaveDivisionTeam(Team $team, Season $season) {
    $dt_record = Division_Team::getRecord($team->id, $season->id);
    if ($dt_record) {
      if ($dt_record->active) {
        $dt_record->status = '';
        $dt_record->active = 0;
        $dt_record->save();
        return true;
      }
    }
    return true;
  }
}
