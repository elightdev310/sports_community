<?php

namespace App\SC\Libs;

use DB;
use Auth;
use Mail;

use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

use App\Role;
use App\SC\Models\User;
use App\SC\Models\Post;
use App\SC\Models\PostComment;

use Exception;
use SCUserLib;

class PostLib 
{
  /**
   * Laravel application
   *
   * @var \Illuminate\Foundation\Application
   */
  public $app;

  /**
   * Create a new confide instance.
   *
   * @param \Illuminate\Foundation\Application $app
   *
   * @return void
   */
  public function __construct($app)
  {
    $this->app = $app;
  }

  public function getPosts($group) 
  {
    $posts = Post::where('group_nid', '=', $group->id)
                 ->orderBy('created_at', 'DESC')
                 ->get();
    $data = array();
    foreach ($posts as $post) {
      $data[$post->id] = array(
        'post' => $post, 
        'comments' => $this->getPostComments($post), 
      );
    }
    return $data;
  }

  public function getPostComments(Post $post)
  {
    $comments = $post->getComments();
    $data = array();
    foreach ($comments as $comment) {
      $data[$comment->id] = array(
        'comment' => $comment, 
        'replies' => $this->getReplies($comment)
      );
    }
    return $data;
  }

  public function getReplies(PostComment $comment) {
    return PostComment::where('pid', '=', $comment->id)
                      ->orderBy('created_at', 'ASC')
                      ->get();
  }

  public function addPost($group, $data) {
    extract($data);
    $currentUser = SCUserLib::currentUser();

    $post = Post::create([
                'text'      => $status, 
                'group_nid' => $group->id, 
                'author_uid'=> $currentUser->id
            ]);
    return $post;
  }

  public function addComment($post, $data) {
    extract($data);
    $currentUser = SCUserLib::currentUser();

    $comment = PostComment::create([
                'text'      => $status, 
                'post_id'   => $post->id, 
                'pid'       => 0, 
                'author_uid'=> $currentUser->id
            ]);
    return $comment;
  }

  public function replyComment($comment, $data) {
    extract($data);
    $currentUser = SCUserLib::currentUser();

    $reply = PostComment::create([
                'text'      => $status, 
                'post_id'   => $comment->post_id, 
                'pid'       => $comment->id, 
                'author_uid'=> $currentUser->id
            ]);
    return $reply;
  }
}
