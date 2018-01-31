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

use SCLeagueLib;
use SCUserLib;
use SCHelper;
use Exception;

/**
 * Class LeagueController
 * @package App\Http\Controllers\SC\Comm\League
 */
class LeagueController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    
  }

  /**
   * URL (/leagues)
   * 
   * My Leagues Page
   */
  public function myLeaguesPage(Request $request)
  {
    $currentUser = SCUserLib::currentUser();
    $m_leagues = $currentUser->getManagedLeagues();

    $params = array();
    $params['m_leagues'] = $m_leagues;

    return view('sc.comm.league.my_leagues', $params);
  }
  
  /**
   * URL (/leagues/create)
   * 
   * Create League
   */
  public function createLeaguePage(Request $request)
  {
    $currentUser = SCUserLib::currentUser();

    $params = array();

    return view('sc.comm.league.create_league', $params);
  }
  public function createLeagueAction(Request $request)
  {
    $currentUser = SCUserLib::currentUser();

    $validator = Validator::make($request->all(), [
        'name'   => 'required', 
      ]);

    $name = $request->input('name');
    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    } else if (SCLeagueLib::checkLeagueExist($name)) {
      return redirect()->back()->withErrors("League name exists. Please try another name.")->withInput();
    }
    $league = SCLeagueLib::createLeague(array(
      'name'        => $name, 
      'creator_uid' => $currentUser->id
    ));
    if (!$league) {
      return redirect()->back()->withErrors("Failed to create league.")->withInput();
    }
    return redirect()->back()->withInput()->with('redirect', '_parent');
  }

  /**
   * URL (/leagues/{slug})
   * 
   * Individual League Page
   */
  public function leaguePage(Request $request, $slug)
  {
    $currentUser = SCUserLib::currentUser();

    $league = League::getLeague($slug);

    $params = array();
    $params['league'] = $league;

    return view('sc.comm.league.league', $params);
  }
}
