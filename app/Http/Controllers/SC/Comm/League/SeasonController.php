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
use App\SC\Models\League_Member;

use SCLeagueLib;
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
    $params['node'] = $league->getNode();
    $this->setLeaguePageParam($league, $params);

    return view('sc.comm.league.seasons', $params);
  }

}