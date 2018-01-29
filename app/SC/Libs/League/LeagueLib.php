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
use App\SC\Models\League;

use SCHelper;

class LeagueLib 
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
   * Create League 
   * @param  $data: array(name, creator_uid)
   */
  public function createLeague($data=array()) {
    // TODO: check duplication of league name
    $league = League::create([
        'name'        => $data['name'], 
        'creator_uid' => $data['creator_uid'], 
    ]);

    if ($league) {
      $league = $league->initialize();
    }

    return $league;
  }
  public function checkLeagueExist($name) {
    $count = League::where('name', $name)->count();
    if ($count) { return true; }
    return false;
  }
}
