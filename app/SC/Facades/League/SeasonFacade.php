<?php 

namespace App\SC\Facades\League;

/**
 * 
 */

use Illuminate\Support\Facades\Facade;

class SeasonFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
      return 'scleague_season';
    }
}
