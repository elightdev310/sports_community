<?php 

namespace App\SC\Facades;

/**
 * 
 */

use Illuminate\Support\Facades\Facade;

class PhotoFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
      return 'scphoto';
    }
}
