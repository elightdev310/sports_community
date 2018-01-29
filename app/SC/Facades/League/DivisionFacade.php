<?php 

namespace App\SC\Facades\League;

/**
 * 
 */

use Illuminate\Support\Facades\Facade;

class DivisionFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
      return 'scleague_division';
    }
}
