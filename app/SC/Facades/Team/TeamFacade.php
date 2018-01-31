<?php 

namespace App\SC\Facades\Team;

/**
 * 
 */

use Illuminate\Support\Facades\Facade;

class TeamFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
      return 'scteam_team';
    }
}
