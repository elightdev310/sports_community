<?php 

namespace App\SC\Facades\League;

/**
 * 
 */

use Illuminate\Support\Facades\Facade;

class Division_TeamFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
      return 'scleague_division_team';
    }
}
