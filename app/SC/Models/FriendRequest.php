<?php
namespace App\SC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\FriendRequest as FriendRequestModule;

class FriendRequest extends FriendRequestModule
{
    
    public function user() {
        return $this->belongsTo('App\SC\Models\User');
    }

    public function friend() {
        return $this->belongsTo('App\SC\Models\User', 'friend_uid');
    }
}
