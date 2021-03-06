<?php
/**
 * 
 */

namespace App\SC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Division as DivisionModule;

class Division extends DivisionModule
{
  public function league() {
    return $this->belongsTo('App\SC\Models\League');
  }
}
