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
use App\Http\Controllers\Controller as Controller;

use Illuminate\Support\Facades\Input;

use App\SC\Models\User;
use App\SC\Models\Team;
use App\SC\Models\Team_Member;

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
    $r_teams = $currentUser->getRequestTeams();

    $params = array();
    $params['tab'] = 'my_teams';
    $params['m_teams'] = $m_teams;
    $params['r_teams'] = $r_teams;


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
    $params['active_page'] = '';
    $params['team'] = $team;
    $params['node'] = $team->getNode();
    $this->setTeamPageParam($team, $params);

    return view('sc.comm.team.team', $params);
  }

  /**
   * URL (/teams/{slug}/discussion)
   * 
   * Team discussion page
   */
  public function teamDiscussionPage(Request $request, $slug)
  {
    $currentUser = SCUserLib::currentUser();
    $team = Team::getTeam($slug);

    $params = array();
    $params['active_page'] = 'team_discussion';
    $params['team'] = $team;
    $params['node'] = $team->getNode();
    $this->setTeamPageParam($team, $params);
    if ($currentUser) {
      $params['postable'] = 1;
    } else {
      $params['postable'] = 0;
    }

    $params['posts_url'] = route('timeline.load_post', 
                                 ['group'=>$params['node'], 'type'=>'timeline']);


    

    return view('sc.comm.team.discussion', $params);
  }

  /**
   * URL (/teams/{slug}/members)
   * 
   * Team members page
   */
  public function teamMembersPage(Request $request, $slug)
  {
    $team = Team::getTeam($slug);

    $params = array();
    $params['active_page'] = 'team_members';
    $params['team'] = $team;
    $params['members'] = $team->members();
    $params['requests']= $team->getJoinRequests();
    $this->setTeamPageParam($team, $params);

    return view('sc.comm.team.members', $params);
  }

  protected function setTeamPageParam($team, &$params) {
    $currentUser = SCUserLib::currentUser();

    if ($currentUser) {
      $params['is_team_manager'] = SCTeamLib::isTeamManager($currentUser->id, $team);
      $params['is_team_member'] = SCTeamLib::isTeamMember($currentUser->id, $team);
      $params['tm_record'] = Team_Member::getRecord($team->id, $currentUser->id);
    } else {
      $params['is_team_manager'] = false;
      $params['is_team_member'] = false;
    }
  }
}

