<?php 

namespace App\SC\Facades\League;

/**
 * 
 */

use Illuminate\Support\Facades\Facade;

class LeagueFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
      return 'scleague_league';
    }
}
