<?php

namespace App\SC\Libs\League;

use DB;
use Auth;
use Mail;

use Exception;

use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;
use Dwij\Laraadmin\Helpers\LAHelper;

use App\Role;
use App\SC\Models\User;
use App\SC\Models\Season;

use SCHelper;

class SeasonLib 
{
  /**
   * Laravel application
   *
   * @var \Illuminate\Foundation\Application
   */
  public $app;

  /**
   * Create a new confide instance.
   *
   * @param \Illuminate\Foundation\Application $app
   *
   * @return void
   */
  public function __construct($app)
  {
      $this->app = $app;
  }

  /**
   * Create Season 
   * @param  $data: array(name)
   */
  public function createSeason($data=array()) {
    // TODO: check duplication of season name
    $season = Season::create([
      'name'        => $data['name'], 
      'start_date'  => date('Y-m-d', $data['start_date']), 
      'end_date'    => date('Y-m-d', $data['end_date']), 
      'league_id'   => $data['league']->id
    ]);

    if ($season) {
      // TODO: notification of new season
    }

    return $season;
  }
}
