<?php
/**
 * 
 */

namespace App\Http\Controllers\SC\Comm\Team;

use Auth;
use Validator;
use Mail;
use DB;

use App\Http\Requests;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;

use App\SC\Models\User;
use App\SC\Models\Team;
use App\SC\Models\Team_Member;
use App\SC\Models\League;
use App\SC\Models\League_Team;

use SCTeamLib;
use SCLeagueLib;
use SCUserLib;
use SCHelper;
use Exception;

trait TeamLeagueController
{
  /**
   * URL (/teams/{slug}/leagues)
   * 
   * Leagues related to team page
   */
  public function teamLeaguesPage(Request $request, $slug)
  {
    $team = Team::getTeam($slug);

    $params = array();
    $params['active_page'] = 'team_leagues';
    $params['team'] = $team;
    $params['requests']= $team->getJoinLeagueRequests();
    $params['leagues'] = $team->getJoinedLeagues();
    $this->setTeamPageParam($team, $params);
    
    return view('sc.comm.team.leagues', $params);
  }

  /**
   * URL (/teams/{slug}/leagues/search)
   * 
   * Search league
   */
  public function teamSearchLeaguePage(Request $request, $slug)
  {
    $team = Team::getTeam($slug);

    $params = array();
    $params['active_page'] = 'team_leagues';
    $params['team'] = $team;
    $this->setTeamPageParam($team, $params);

    if ($term = $request->input('term')) {
      $params['leagues'] = SCLeagueLib::searchLeagueWithTeam($team, $term);
    }

    return view('sc.comm.team.search_league', $params);
  }

  /**
   * URL (/teams/{team}/leagues/{league}/relationship)
   * 
   * Team-Member Relationship Action
   */
  public function teamLeagueRelationshipAction(Request $request, $slug, League $league)
  {
    $team = Team::getTeam($slug);
    $action = $request->input('action');
    $lt_record = League_Team::getRecord($league->id, $team->id);

    $json = array(
        "status" => "success",
      );

    switch ($action) {
      case 'send': 
        $result = SCTeamLib::sentRequestLeagueTeam($league->id, $team->id);
        if ($result) {
          if ($result == 10) {
            $json['status'] = 'warning';
            $json['code']   = $result;
            $json['action'] = 'reload';
          } else {

          }
        } else {
          $json['status'] = 'error';
          $json['message']= 'Failed to send request.';
        }
        break;

      case 'cancel': 
        $result = SCTeamLib::cancelRequestLeagueTeam($league->id, $team->id);
        if ($result) {
          if ($result == 10) {
            $json['status'] = 'warning';
            $json['code']   = $result;
            $json['action'] = 'reload';
          } else {

          }
        } else {
          $json['status'] = 'error';
          $json['message']= 'Failed to cancel request.';
        }
        break;

      case 'allow': 
        $result = SCTeamLib::allowLeagueTeam($league->id, $team->id);
        if ($result) {
          $json['action'] = 'reload';
        } else {
          $json['status'] = 'error';
          $json['message']= 'Failed to allow member.';
        }
        break;

      case 'leave': 
        $result = SCTeamLib::leaveLeagueTeam($league->id, $team->id);
        if ($result) {
          $json['action'] = 'reload';
        } else {
          $json['status'] = 'error';
          $json['message']= 'Failed to leave member.';
        }
        
        break;
    }

    return response()->json($json);
  }
}