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
use App\SC\Models\Division;

use SCHelper;

class DivisionLib 
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
   * Create Division 
   * @param  $data: array(name, league)
   */
  public function createDivision($data=array()) {
    if ($this->checkDivisionExist($data['name'], $data['league'])) {
      return 'exist';
    }

    $division = Division::create([
        'name'        => $data['name'], 
        'league_id'   => $data['league']->id, 
    ]);

    return $division;
  }
  public function checkDivisionExist($name, League $league) {
    $count = Division::where('name', $name)
              ->where('league_id', $league->id)
              ->count();
    if ($count) { return true; }
    return false;
  }
  public function getDivisionByName($name, League $league) {
    $division = Division::where('name', $name)
              ->where('league_id', $league->id)
              ->first();
    return $division;
  }
}
