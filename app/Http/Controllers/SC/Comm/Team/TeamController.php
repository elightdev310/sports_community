<?php
/**
 * 
 */

namespace App\Http\Controllers\SC\Comm\Team;

use Auth;
use Validator;
use Mail;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

use Illuminate\Support\Facades\Input;

use App\SC\Models\User;
use App\SC\Models\Team;

use SCTeamLib;
use SCUserLib;
use SCHelper;
use Exception;

/**
 * Class TeamController
 * @package App\Http\Controllers\SC\Comm\Team
 */
class TeamController extends Controller
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
   * URL (/teams)
   * 
   * My Teams Page
   */
  public function myTeamsPage(Request $request)
  {
    $currentUser = SCUserLib::currentUser();
    $m_teams = $currentUser->getManagedTeams();

    $params = array();
    $params['tab'] = 'my_teams';
    $params['m_teams'] = $m_teams;

    return view('sc.comm.team.my_teams', $params);
  }

  /**
   * URL (/teams/create)
   * 
   * Create team
   */
  public function createTeamPage(Request $request)
  {
    $currentUser = SCUserLib::currentUser();

    $params = array();

    return view('sc.comm.team.create_team', $params);
  }
  public function createTeamAction(Request $request)
  {
    $currentUser = SCUserLib::currentUser();

    $validator = Validator::make($request->all(), [
        'name'   => 'required', 
      ]);

    $name = $request->input('name');
    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    } else if (SCTeamLib::checkTeamExist($name)) {
      return redirect()->back()->withErrors("Team name exists. Please try another name.")->withInput();
    }
    $team = SCTeamLib::createTeam(array(
      'name'        => $name, 
      'creator_uid' => $currentUser->id
    ));
    if (!$team) {
      return redirect()->back()->withErrors("Failed to create team.")->withInput();
    }
    return redirect()->back()->withInput()->with('redirect', '_parent');
  }

  /**
   * URL (/teams/search)
   * 
   * search team
   */
  public function searchTeamPage(Request $request)
  {
    $currentUser = SCUserLib::currentUser();

    $params = array();
    $params['tab'] = 'search';

    if ($term = $request->input('term')) {
      $params['teams'] = SCTeamLib::searchTeam($term);
    }

    return view('sc.comm.team.search_team', $params);
  }

  /**
   * URL (/teams/{team}/member-relationship)
   * 
   * Team-Member Relationship Action
   */
  public function memberRelationshipAction(Request $request, Team $team)
  {
    $currentUser = SCUserLib::currentUser();
    $action = $request->input('action');

    $json = array(
        "status" => "success",
      );

    switch ($action) {
      case 'send': 
        $result = SCTeamLib::sentRequestTeamMember($currentUser->id, $team->id);
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
        $result = SCTeamLib::cancelRequestTeamMember($currentUser->id, $team->id);
        if ($result) {
          
        } else {
          $json['status'] = 'error';
          $json['message']= 'Failed to cancel request.';
        }
        break;
    }

    return response()->json($json);
  }

  /**
   * URL (/teams/{slug})
   * 
   * Individual team Page
   */
  public function teamPage(Request $request, $slug)
  {
    $currentUser = SCUserLib::currentUser();

    $team = Team::getTeam($slug);

    $params = array();
    $params['team'] = $team;

    return view('sc.comm.team.team', $params);
  }
}
