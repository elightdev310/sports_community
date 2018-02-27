<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\SC\Models;

use DB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Team as TeamModule;

use SCHelper;

class Team extends TeamModule
{
  const TABLE_NAME = 'teams';
  const NODE_TYPE  = 'team';

  public function initialize($data=array()) 
  {
    $this->slug = SCHelper::createSlug($this->name, self::TABLE_NAME);
    $this->save();
    
    $node = Node::create([
        'object_id'   => $this->id, 
        'type'        => self::NODE_TYPE, 
        'user_id'     => $this->creator_uid, 
    ]);
    return $this;
  }
  public function getNode() 
  {
    $node = Node::where('object_id', '=', $this->id)
                ->where('type', '=', self::NODE_TYPE)
                ->first();
    return $node;
  }
  public static function getTeam($slug) 
  {
    $league_id = SCHelper::getObjectIDBySlug($slug, self::TABLE_NAME);
    if ($league_id) {
      return self::find($league_id);
    }
    return null;
  }

  /**
   * get URL of cover photo
   */
  public function coverPhotoPath() 
  {
    $node = $this->getNode();
    if ($node) {
      return $node->coverPhotoPath();
    }
    return false;
  }

  /**
   * Get Members
   */
  public function members() 
  {
    $members = DB::table('users')
              ->select('users.*')
              ->rightJoin('team_members AS tm', 'users.id', '=', 'tm.user_id')
              ->where('tm.team_id', $this->id)
              ->where('tm.active', 1)
              ->orderBy('tm.created_at', 'ASC')
              ->get();
    return $members;
  }

  /**
   * Get Join Requests
   */
  public function getJoinRequests() 
  {
    $requests = DB::table('users')
              ->select('users.*')
              ->addSelect('tm.status AS status')
              ->rightJoin('team_members AS tm', 'users.id', '=', 'tm.user_id')
              ->where('tm.team_id', $this->id)
              ->where('tm.active', 0)
              ->where('tm.status', '<>', '')
              ->orderBy('tm.created_at', 'ASC')
              ->get();
    return $requests;
  }

  /**
   * Get Joined Leagues of Team
   */
  public function getJoinedLeagues()
  {
    $leagues = DB::table('leagues AS l')
                ->rightJoin('league_teams AS lt', 'l.id', '=', 'lt.league_id')
                ->select('l.*')
                ->addSelect('lt.status')
                ->addSelect('lt.active')
                ->where('lt.team_id', $this->id)
                ->where('lt.active', 1)
                ->orderBy('lt.created_at', 'ASC')
                ->get();
    return $leagues;
  }

  /**
   * Get Join League Requests
   */
  public function getJoinLeagueRequests() 
  {
    $requests = DB::table('leagues AS l')
              ->rightJoin('league_teams AS lt', 'l.id', '=', 'lt.league_id')
              ->select('l.*')
              ->addSelect('lt.status')
              ->addSelect('lt.active')
              ->where('lt.team_id', $this->id)
              ->where('lt.active', 0)
              ->where('lt.status', '<>', '')
              ->orderBy('lt.created_at', 'ASC')
              ->get();
    return $requests;
  }
}
