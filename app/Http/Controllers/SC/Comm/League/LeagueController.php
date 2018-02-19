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
    $params['tab'] = 'my_leagues';
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
   * URL (/leagues/search)
   * 
   * search league
   */
  public function searchLeaguePage(Request $request)
  {
    $currentUser = SCUserLib::currentUser();

    $params = array();
    $params['tab'] = 'search';

    if ($term = $request->input('term')) {
      $params['leagues'] = SCLeagueLib::searchLeague($term);
    }

    return view('sc.comm.league.search_league', $params);
  }

  /**
   * URL (/leagues/{league}/member-relationship)
   * 
   * League-Member Relationship Action
   */
  public function memberRelationshipAction(Request $request, League $league)
  {
    $currentUser = SCUserLib::currentUser();
    $action = $request->input('action');

    $json = array(
        "status" => "success",
      );

    switch ($action) {
      case 'send': 
        $result = SCLeagueLib::sentRequestLeagueMember($currentUser->id, $league->id);
        if ($result) {
          if ($result == 10) {
            $json['status'] = 'warning';
            $json['code']   = $result;
          } else {

          }
        } else {
          $json['status'] = 'error';
          $json['message']= 'Failed to send request.';
        }
        break;

      case 'cancel': 
        $result = SCLeagueLib::cancelRequestLeagueMember($currentUser->id, $league->id);
        if ($result) {
          
        } else {
          $json['status'] = 'error';
          $json['message']= 'Failed to cancel request.';
        }
        break;

      case 'allow': 
        $user_id= $request->input('user_id');
        if ($user=User::find($user_id)) {
          $result = SCLeagueLib::allowLeagueMember($user_id, $league->id);
        } else {
          $result = false;
        }
        if ($result) {
          $json['action'] = 'reload';
        } else {
          $json['status'] = 'error';
          $json['message']= 'Failed to allow member.';
        }
        break;

      case 'leave': 
        if (Input::has('user_id')) {
          $user_id = $request->input('user_id');
        } else {
          $user_id = $currentUser->id;
        }
        if ($user=User::find($user_id)) {
          $result = SCLeagueLib::leaveLeagueMember($user_id, $league->id);
        } else {
          $result = false;
        }
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
    $params['active_page'] = '';
    $params['league'] = $league;
    $params['node'] = $league->getNode();
    
    $this->setLeaguePageParam($league, $params);

    return view('sc.comm.league.league', $params);
  }

  /**
   * URL (/leagues/{slug}/discussion)
   * 
   * league discussion page
   */
  public function leagueDiscussionPage(Request $request, $slug)
  {
    $currentUser = SCUserLib::currentUser();
    $league = League::getLeague($slug);

    $params = array();
    $params['active_page'] = 'league_discussion';
    $params['league'] = $league;
    $params['node'] = $league->getNode();
    $this->setLeaguePageParam($league, $params);

    if ($currentUser) {
      $params['postable'] = 1;
    } else {
      $params['postable'] = 0;
    }

    $params['posts_url'] = route('timeline.load_post', 
                                 ['group'=>$params['node'], 'type'=>'timeline']);

    return view('sc.comm.league.discussion', $params);
  }

  /**
   * URL (/leagues/{slug}/members)
   * 
   * league members page
   */
  public function leagueMembersPage(Request $request, $slug)
  {
    $league = League::getLeague($slug);

    $params = array();
    $params['active_page'] = 'league_members';
    $params['league'] = $league;
    $params['members'] = $league->members();
    $params['requests']= $league->getJoinRequests();
    $this->setLeaguePageParam($league, $params);

    return view('sc.comm.league.members', $params);
  }

  protected function setLeaguePageParam($league, &$params) {
    $currentUser = SCUserLib::currentUser();

    if ($currentUser) {
      $params['is_league_manager'] = SCLeagueLib::isLeagueManager($currentUser->id, $league);
      $params['is_league_member'] = SCLeagueLib::isLeagueMember($currentUser->id, $league->id);
      $params['lm_record'] = League_Member::getRecord($league->id, $currentUser->id);
    } else {
      $params['is_league_manager'] = false;
      $params['is_league_member'] = false;
    }
  }
}
