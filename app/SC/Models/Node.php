<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\SC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Node as NodeModule;

class Node extends NodeModule
{
    
    public function user() {
        return $this->belongsTo('App\SC\Models\User');
    }
}
