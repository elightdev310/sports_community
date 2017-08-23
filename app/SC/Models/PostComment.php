<?php
namespace App\SC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\PostComment as PostCommentModule;

class PostComment extends PostCommentModule
{
    public function author() {
        return $this->belongsTo('App\SC\Models\User', 'author_uid');
    }

    public function group() {
      return $this->belongsTo('App\SC\Models\Node', 'group_nid');
    }

    public function parent() {
      return $this->belongsTo('App\SC\Models\PostComment', 'pid');
    }
}
