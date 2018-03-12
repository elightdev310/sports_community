<?php
/**
 * 
 */

namespace App\SC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Season as SeasonModule;

use DB;

use SCNodeLib;
use SCUserLib;
use SCHelper;

class Season extends SeasonModule
{
  const TABLE_NAME = 'seasons';
  const NODE_TYPE  = 'season';
  
  public function initialize($data=array()) {
    $currentUser = SCUserLib::currentUser();

    // $this->slug = SCHelper::createSlug($this->name, self::TABLE_NAME);
    // $this->save();
    
    $node = Node::create([
        'object_id'   => $this->id, 
        'type'        => self::NODE_TYPE, 
        'user_id'     => $currentUser->id, 
    ]);
    return $this;
  }

  public function getNode() {
    return SCNodeLib::getNode($this->id, self::NODE_TYPE);
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

  public function league() {
    return $this->belongsTo('App\SC\Models\League');
  }

  public function isArchived() {
    return $this->end_date >= date(SCHelper::DB_DATE_FORMAT);
  }

  public function getDivisionTeamRequests() {
    $query = "SELECT t.*, dt.active, dt.status 
              FROM teams AS t 
              LEFT JOIN division_teams AS dt 
                    ON (t.id=dt.team_id) 
              WHERE dt.season_id = ? AND dt.active = 0 AND dt.status<>'' ";
    $r_teams = DB::select($query, array($this->id));
    return $r_teams;
  }

  public function getDivisionTeams() {
    $query = "SELECT t.*, dt.active, dt.status, dt.division_id  
              FROM teams AS t 
              LEFT JOIN division_teams AS dt 
                    ON (t.id=dt.team_id) 
              WHERE dt.season_id = ? AND dt.active = 1";
    $teams = DB::select($query, array($this->id));
    return $teams;
  }
}
