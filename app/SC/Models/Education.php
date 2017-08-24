<?php

namespace App\SC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Education as EducationModule;

class Education extends EducationModule
{
    public function user() {
        return $this->belongsTo('App\SC\Models\User');
    }
}
