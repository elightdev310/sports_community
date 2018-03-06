<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\SC\Models;

use DB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\League as LeagueModule;

use SCNodeLib;
use SCHelper;

class League extends LeagueModule
{
  const TABLE_NAME = 'leagues';
  const NODE_TYPE  = 'league';

  public function initialize($data=array()) {
    $this->slug = SCHelper::createSlug($this->name, self::TABLE_NAME);
    $this->save();
    
    $node = Node::create([
        'object_id'   => $this->id, 
        'type'        => self::NODE_TYPE, 
        'user_id'     => $this->creator_uid, 
    ]);
    return $this;
  }
  public function getNode() {
    return SCNodeLib::getNode($this->id, self::NODE_TYPE);
  }
  public static function getLeague($slug) {
    $league_id = SCHelper::getObjectIDBySlug($slug, self::TABLE_NAME);
    if ($league_id) {
      return self::find($league_id);
    }
    return null;
  }

  /**
   * get URL of cover photo
   */
  public function coverPhotoPath() {
    $node = $this->getNode();
    if ($node) {
      return $node->coverPhotoPath();
    }
    return false;
  }

  /**
   * Get Members
   */
  public function members() {
    $members = DB::table('users')
              ->rightJoin('league_members AS lm', 'users.id', '=', 'lm.user_id')
              ->select('users.*')
              ->addSelect('lm.active AS active')
              ->addSelect('lm.status AS status')
              ->where('lm.league_id', $this->id)
              ->where('lm.active', 1)
              ->orderBy('lm.created_at', 'ASC')
              ->get();
    return $members;
  }

  /**
   * Get Join Requests
   */
  public function getJoinRequests() {
    $requests = DB::table('users')
              ->rightJoin('league_members AS lm', 'users.id', '=', 'lm.user_id')
              ->select('users.*')
              ->addSelect('lm.active AS active')
              ->addSelect('lm.status AS status')
              ->where('lm.league_id', $this->id)
              ->where('lm.active', 0)
              ->where('lm.status', '<>', '')
              ->orderBy('lm.created_at', 'ASC')
              ->get();
    return $requests;
  }

  /**
   * Get League Teams
   */
  public function teams() {
    $members = DB::table('teams')
              ->rightJoin('league_teams AS lt', 'teams.id', '=', 'lt.team_id')
              ->select('teams.*')
              ->addSelect('lt.active AS active')
              ->addSelect('lt.status AS status')
              ->where('lt.league_id', $this->id)
              ->where('lt.active', 1)
              ->orderBy('lt.created_at', 'ASC')
              ->get();
    return $members;
  }

  /**
   * Get Join Team Requests
   */
  public function getJoinTeamRequests() {
    $requests = DB::table('teams')
              ->rightJoin('league_teams AS lt', 'teams.id', '=', 'lt.team_id')
              ->select('teams.*')
              ->addSelect('lt.active AS active')
              ->addSelect('lt.status AS status')
              ->where('lt.league_id', $this->id)
              ->where('lt.active', 0)
              ->where('lt.status', '<>', '')
              ->orderBy('lt.created_at', 'ASC')
              ->get();
    return $requests;
  }

  /**
   * Get Seasons
   */
  public function seasons() {
    $seasons = Season::where('league_id', $this->id)
              ->where('end_date', '>=', date('Y-m-d'))
              ->orderBy('start_date', 'ASC')
              ->get();
    return $seasons;
  }
  public function archivedSeasons() {
    $seasons = Season::where('league_id', $this->id)
              ->where('end_date', '<', date('Y-m-d'))
              ->orderBy('start_date', 'ASC')
              ->get();
    return $seasons;
  }
}
