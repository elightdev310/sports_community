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
    $query = "SELECT dt.*, t.slug
              FROM division_teams AS dt 
              LEFT JOIN teams AS t 
                    ON (t.id=dt.team_id) 
              WHERE dt.season_id = ? AND dt.active = 0 AND dt.status<>'' ";
    $r_teams = DB::select($query, array($this->id));
    return $r_teams;
  }

  public function getDivisionTeams() {
    $query = "SELECT dt.*, t.slug  
              FROM division_teams AS dt 
              LEFT JOIN teams AS t 
                    ON (t.id=dt.team_id) 
              LEFT JOIN divisions AS d 
                    ON (d.id=dt.division_id) 
              WHERE dt.season_id = ? AND dt.active = 1 
              ORDER BY d.name ASC, dt.team_name ASC";
    $teams = DB::select($query, array($this->id));
    $data = array();
    foreach ($teams as $team) {
      if ($team->division_id && !isset($data[$team->division_id]['division'])) {
        $data[$team->division_id]['division'] = Division::find($team->division_id);
      }
      $data[$team->division_id]['teams'][] = $team;
    }
    return $data;
  }
}
