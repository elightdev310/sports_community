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

use App\SC\Models\Node;

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




  /**
   * Get Feed Posts
   */
  public function getFeedPosts(Node $group, $type, $params=array()) {
    if (!isset($params['page']))    { $params['page'] = 0; }
    if (!isset($params['perPage'])) { $params['perPage'] = 3; }     // Default

    $posts = array();
    switch ($group->type) {
      case 'user':
        if ($type == 'timeline') {
          $posts = $this->getUserTimelinePosts($group, $params);
        }
        break;
      case 'team':
      case 'league':
        if ($type == 'timeline') {
          $posts = $this->getNodeTimelinePosts($group, $params);
        }
        break;
    }

    $data = array();
    foreach ($posts as $post) {
      $data[$post->id] = array(
        'post' => $post, 
        'comments' => $this->getPostComments($post), 
      );
    }
    return $data;
  }

  /**
   * Get Post in Feeds
   */
  public function getPostsInFeeds($follow_fids, $params) {
    $currentUser = SCUserLib::currentUser();

    $perPage = $params['perPage'];
    $offset = $params['page'] * $perPage;

    $str_follow_fids = implode(', ', $follow_fids);

    $query = "SELECT p.* 
              FROM posts AS p 
              WHERE group_nid IN ($str_follow_fids) 
              ORDER BY p.updated_at DESC 
              LIMIT $offset, $perPage";
    $results = DB::select($query);
    $posts = array();
    if ($results) {
      foreach ($results as $post) {
        $posts[$post->id] = Post::find($post->id);
      }
    }
    return $posts;
  }

  /**
   * Get User Timeline Posts
   */
  public function getUserTimelinePosts(Node $group, $params) {
    $follow_fids = array($group->id => $group->id);
    $posts = $this->getPostsInFeeds($follow_fids, $params);
    return $posts;
  }

  /**
   * Get Timeline Posts
   */
  public function getNodeTimelinePosts(Node $group, $params) {
    $follow_fids = array($group->id => $group->id);
    $posts = $this->getPostsInFeeds($follow_fids, $params);
    return $posts;
  }

}
