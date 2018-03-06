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

use SCLeagueLib;
use SCSeasonLib;
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

    $this->setLeaguePageParam($league, $params);

    return view('sc.comm.league.season.season_page', $params);
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
}