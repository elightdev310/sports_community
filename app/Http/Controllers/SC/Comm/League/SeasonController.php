<?php
/**
 * 
 */

namespace App\Http\Controllers\SC\Comm\League;

use Auth;
use Validator;
use Mail;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

use Illuminate\Support\Facades\Input;

use App\SC\Models\User;
use App\SC\Models\League;
use App\SC\Models\Season;
use App\SC\Models\Team;

use SCLeagueLib;
use SCSeasonLib;
use SCDivision_TeamLib;

use SCUserLib;
use SCHelper;
use Exception;

trait SeasonController
{
  /**
   * URL (/leagues/{slug}/seasons)
   * 
   * league seasons page
   */
  public function leagueSeasonsPage(Request $request, $slug)
  {
    $currentUser = SCUserLib::currentUser();
    $league = League::getLeague($slug);

    $params = array();
    $params['active_page'] = 'league_seasons';
    $params['league'] = $league;
    $params['node']   = $league->getNode();

    $params['seasons']  = $league->seasons();
    $params['archived'] = $league->archivedSeasons();

    $this->setLeaguePageParam($league, $params);

    return view('sc.comm.league.seasons', $params);
  }

  /**
   * URL (/leagues/{slug}/seasons/add)
   * 
   * add season page
   */
  public function addSeasonPage(Request $request, $slug)
  {
    $currentUser = SCUserLib::currentUser();
    $league = League::getLeague($slug);

    $params = array();
    $params['league'] = $league;
    $params['node'] = $league->getNode();
    $this->setLeaguePageParam($league, $params);

    return view('sc.comm.league.season.add_season', $params);
  }
  public function addSeasonAction(Request $request, $slug)
  {
    $currentUser = SCUserLib::currentUser();
    $league = League::getLeague($slug);

    $validator = Validator::make($request->all(), [
        'name'        => 'required', 
        'start_date'  => 'required', 
        'end_date'    => 'required', 
      ]);
    
    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    } 
    
    $start = strtotime($request->input('start_date'));
    $end   = strtotime($request->input('end_date'));

    $season = SCSeasonLib::createSeason(array(
      'name'        => $request->input('name'), 
      'start_date'  => $start, 
      'end_date'    => $end, 
      'league'      => $league
    ));
    
    if ($season) {
      return redirect()->back()->withInput()->with('redirect', '_parent');
    }

    return redirect()->back()->withErrors('Failed to add season.')->withInput();
  }


  /**
   * URL (/leagues/{slug}/seasons/{season})
   * 
   * Individual season page
   */
  public function seasonPage(Request $request, $slug, Season $season)
  {
    $currentUser = SCUserLib::currentUser();
    $league = League::getLeague($slug);
    if ($league->id != $season->league_id) {
      return redirect()->route('league.seasons', ['slug'=>$league->slug]);
    }
    $params = array();
    $params['active_page'] = 'season';
    $params['league'] = $league;
    $params['season'] = $season;
    $params['node']   = $season->getNode();

    $params['division_teams'] = $season->getDivisionTeams();

    $this->setLeaguePageParam($league, $params);
    
    if ($params['is_league_manager']) {
      $params['dt_teams'] = $season->getDivisionTeamRequests();
      return view('sc.comm.league.season.season_page', $params);
    } else {
      $params['dt_teams'] = SCDivision_TeamLib::getDivisionTeamsByUser($currentUser->id, $season->id);
      return view('sc.comm.league.season.season_page_public', $params);
    }    
  }

  /**
   * URL (/leagues/{slug}/seasons/{season}/edit)
   * 
   * Edit season page
   */
  public function editSeasonPage(Request $request, $slug, Season $season)
  {
    $currentUser = SCUserLib::currentUser();
    $league = League::getLeague($slug);
    if ($league->id != $season->league_id) {
      return redirect()->route('league.seasons', ['slug'=>$league->slug]);
    }
    $params = array();
    $params['active_page'] = 'edit_season';
    $params['league'] = $league;
    $params['season'] = $season;
    $params['node']   = $season->getNode();

    $this->setLeaguePageParam($league, $params);

    return view('sc.comm.league.season.edit_season', $params);
  }
  public function editSeasonAction(Request $request, $slug, Season $season)
  {
    $currentUser = SCUserLib::currentUser();

    $validator = Validator::make($request->all(), [
      'name'        => 'required', 
      'start_date'  => 'required', 
      'end_date'    => 'required', 
    ]);
  
    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    } 
    
    $league = League::getLeague($slug);
    if ($league->id != $season->league_id) {
      return redirect()->back()->withInput()->with('redirect', '_parent');
    }

    $start = strtotime($request->input('start_date'));
    $end   = strtotime($request->input('end_date'));

    $season = SCSeasonLib::updateSeason($season, array(
      'name'        => $request->input('name'), 
      'start_date'  => $start, 
      'end_date'    => $end, 
      'league'      => $league
    ));
    
    if ($season) {
      return redirect()->back()->withInput()->with('redirect', '_parent');
    }
    
    return redirect()->back()->withErrors('Failed to update season.')->withInput();
  }

  /**
   * User Team Join
   */
  public function userTeamJoinPage(Request $request, $slug, Season $season)
  {
    $currentUser = SCUserLib::currentUser();
    $league = League::getLeague($slug);
    if ($league->id != $season->league_id) {
      return redirect()->back()->with('redirect', '_parent');
    }
    $params = array();
    $params['active_page'] = 'user_team_join';
    $params['league'] = $league;
    $params['season'] = $season;
    $params['node']   = $season->getNode();

    $params['dt_teams'] = SCDivision_TeamLib::getDivisionTeamsByUserTeams($currentUser->id, $season->id);

    $this->setLeaguePageParam($league, $params);

    return view('sc.comm.league.season.user_team_join', $params);
  }
  public function userTeamJoinAction(Request $request, $slug, Season $season, Team $team)
  {
    $currentUser = SCUserLib::currentUser();
    $league = League::getLeague($slug);
    if ($league->id != $season->league_id) {
      return redirect()->back()->with('redirect', '_parent');
    }

    $action = $request->input('action');

    $json = array(
        "status" => "success",
      );

    switch ($action) {
      case 'send': 
        $result = SCDivision_TeamLib::sendRequestDivisionTeam($team, $season);
        if ($result) {
          if ($result == 10) {
            $json['status'] = 'warning';
            $json['code']   = $result;
            $json['action'] = 'reload';
          } else {
            $json['action'] = 'reload';
          }
        } else {
          $json['status'] = 'error';
          $json['message']= 'Failed to send request.';
        }
        break;
      case 'cancel': 
        $result = SCDivision_TeamLib::cancelRequestDivisionTeam($team, $season);
        if ($result) {
          if ($result == 10) {
            $json['status'] = 'warning';
            $json['code']   = $result;
            $json['action'] = 'reload';
          } else {
            $json['action'] = 'reload';
          }
        } else {
          $json['status'] = 'error';
          $json['message']= 'Failed to cancel request.';
        }
        break;
      case 'allow': 
        $result = SCDivision_TeamLib::allowRequestDivisionTeam($team, $season);
        if ($result) {
          if ($result == 10) {
            $json['status'] = 'warning';
            $json['code']   = $result;
            $json['action'] = 'reload';
          } else {
            $json['action'] = 'reload';
          }
        } else {
          $json['status'] = 'error';
          $json['message']= 'Failed to allow request.';
          $json['action'] = 'reload';
        }
        break;
      case 'reject': 
        $result = SCDivision_TeamLib::rejectRequestDivisionTeam($team, $season);
        if ($result) {
          if ($result == 10) {
            $json['status'] = 'warning';
            $json['code']   = $result;
            $json['action'] = 'reload';
          } else {
            $json['action'] = 'reload';
          }
        } else {
          $json['status'] = 'error';
          $json['message']= 'Failed to cancel request.';
          $json['action'] = 'reload';
        }
        break;

      case 'leave': 
        $result = SCDivision_TeamLib::leaveDivisionTeam($team, $season);
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