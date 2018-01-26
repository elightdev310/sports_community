<?php
namespace App\SC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Post as PostModule;
use App\SC\Models\PostComment;

class Post extends PostModule
{
    public function author() {
        return $this->belongsTo('App\SC\Models\User', 'author_uid');
    }

    public function group() {
      return $this->belongsTo('App\SC\Models\Node', 'group_nid');
    }

    public function getComments() {
      return PostComment::where('post_id', '=', $this->id)
                        ->where('pid', '=', 0)
                        ->orderBy('created_at', 'ASC')
                        ->get();
    }

    
}
