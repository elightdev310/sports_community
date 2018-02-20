<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\SC\Models;

use DB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User as UserModule;

use SCPostLib;

class User extends UserModule
{
  use SoftDeletes;

  public function profile() {
    return $this->hasOne('App\SC\Models\UserProfile');
  }

  public function createProfile() {
    $profile = new UserProfile;
    $profile->user_id = $this->id;
    $profile->save();
  }

  public function getNode() {
    $node = Node::where('object_id', '=', $this->id)
                ->where('type', '=', 'user')
                ->first();
    if (!$node) {
      $node = Node::create([
          'object_id'   => $this->id, 
          'type'        => 'user', 
          'user_id'     => $this->id
      ]);
    }
    return $node;
  }

  public function getFriendIDs() {
    $u1 = DB::table('friendships')->select('user1_id as uid')->where('user2_id', '=', $this->id)->get();
    $u2 = DB::table('friendships')->select('user2_id as uid')->where('user1_id', '=', $this->id)->get();
    $u = array_merge($u1, $u2);
    $data = array();
    foreach ($u as $row) {
      $data[$row->uid] = $row->uid;
    }
    return $data;
  }

  /**
   * Get managed Leagues
   */
  public function getManagedLeagues() {
    $leagues = League::where('creator_uid', $this->id)->orderBy('name', 'ASC')->get();
    return $leagues;
  }
  /**
   * Get managed Teams
   */
  public function getManagedTeams() {
    $teams = Team::where('creator_uid', $this->id)->orderBy('name', 'ASC')->get();
    return $teams;
  }

  /**
   * Get Teams that you sent request
   */
  public function getRequestTeams() {
    $teams = DB::table('teams')
              ->rightJoin('team_members AS tm', 'teams.id', '=', 'tm.team_id')
              ->select('teams.*')
              ->addSelect('tm.active')
              ->addSelect('tm.status')
              ->where('tm.user_id', $this->id)
              ->where('tm.active', 0)
              ->where('tm.status', '<>', '')
              ->orderBy('teams.name', 'ASC')
              ->get();
    return $teams;
  }
  /**
   * Get Teams that you sent request
   */
  public function getRequestLeagueMembers() {
    $leagues = DB::table('leagues')
              ->rightJoin('league_members AS lm', 'leagues.id', '=', 'lm.league_id')
              ->select('leagues.*')
              ->addSelect('lm.active')
              ->addSelect('lm.status')
              ->where('lm.user_id', $this->id)
              ->where('lm.active', 0)
              ->where('lm.status', '<>', '')
              ->orderBy('leagues.name', 'ASC')
              ->get();
    return $leagues;
  }

  /**
   * Get joined Teams
   */
  public function getJoinedTeams() {
    $teams = DB::table('teams')
              ->rightJoin('team_members AS tm', 'teams.id', '=', 'tm.team_id')
              ->select('teams.*')
              ->addSelect('tm.active')
              ->addSelect('tm.status')
              ->where('tm.user_id', $this->id)
              ->where('tm.active', 1)   //
              ->orderBy('teams.name', 'ASC')
              ->get();
    return $teams;
  }
  /**
   * Get joined Leagues
   */
  public function getJoinedLeagues() {
    $leagues = DB::table('leagues')
              ->rightJoin('league_members AS lm', 'leagues.id', '=', 'lm.league_id')
              ->select('leagues.*')
              ->addSelect('lm.active')
              ->addSelect('lm.status')
              ->where('lm.user_id', $this->id)
              ->where('lm.active', 1) //
              ->orderBy('leagues.name', 'ASC')
              ->get();
    return $leagues;
  }
}
