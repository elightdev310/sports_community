<?php
/**
 *
 */

namespace App\Http\Controllers\SC\Comm;

use Auth;
use Validator;
use Mail;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;

use App\SC\Models\User;
use App\SC\Models\Node;
use App\SC\Models\Post;
use App\SC\Models\PostComment;
use SCUserLib;
use SCPhotoLib;
use SCPostLib;
use SCHelper;

use Exception;

/**
 * Class ProfileController
 * @package App\Http\Controllers\SC\Comm
 */
class TimelineController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    
  }

  /**
   * URL-POST (/timeline/{group}/post/add)
   */
  public function addPost(Request $request, Node $group)
  {
    $status = $request->input('status');

    try {
      $post = SCPostLib::addPost($group, 
            compact('status'));
      if ($post && isset($post->id)) {
        return response()->json([
            "status" => "success",
            "action" => "reload", 
          ]);
      } else {
        throw new Exception("Failed to add post");
      }
    } catch(Exception $e) {
      return response()->json([
            "status" => "error",
            "message" => SCHelper::getErrorMessage($e), 
          ]);
    }

  }

  /**
   * URL-POST (/timeline/post/{post}/comment/add)
   */
  public function addComment(Request $request, Post $post)
  {
    $status = $request->input('status');

    try {
      $comment = SCPostLib::addComment($post, 
            compact('status'));
      if ($comment && isset($comment->id)) {
        return response()->json([
            "status" => "success",
            "action" => "", 
          ]);
      } else {
        throw new Exception("Failed to write comment");
      }
    } catch(Exception $e) {
      return response()->json([
            "status" => "error",
            "message" => SCHelper::getErrorMessage($e), 
          ]);
    }
  }

  /**
   * URL-POST (/timeline/post/comment/{comment}/reply)
   */
  public function replyComment(Request $request, PostComment $comment)
  {
    $status = $request->input('status');

    try {
      $reply = SCPostLib::replyComment($comment, 
            compact('status'));
      if ($reply && isset($reply->id)) {
        return response()->json([
            "status" => "success",
            "action" => "", 
          ]);
      } else {
        throw new Exception("Failed to write reply");
      }
    } catch(Exception $e) {
      return response()->json([
            "status" => "error",
            "message" => SCHelper::getErrorMessage($e), 
          ]);
    }
  }

  /**
   * URL (/timeline/post/{post}/refresh)
   */
  public function refreshPost(Request $request, Post $post)
  {
    $currentUser = SCUserLib::currentUser();

    try {
      $params = array();
      $params['post'] = $post;
      $params['comments'] = SCPostLib::getPostComments($post);

      $view = View::make('sc.comm.partials.timeline.post_card', $params);
      return response()->json([
            "status" => "success",
            "post_card" => $view->render(), 
          ]);
    } catch(Exception $e) {
      return response()->json([
            "status" => "error",
            "message" => SCHelper::getErrorMessage($e), 
          ]);
    }

  }

  /**
   * URL - POST (ajax) : timeline/load-post/{group}/{type}
   */
  public function load_next_posts(Request $request, Node $group, $type)
  {
    $currentUser = SCUserLib::currentUser();

    $result = array(
        'status' => 'success', 
        'msg'    => '', 
        'posts'  => ''
    );

    $page = $request->has('page')? $request->input('page') : 0;
    $result['nextPage'] = $page;

    $posts = SCPostLib::getFeedPosts($group, $type, array('page'=>$page));

    if ($posts && !empty($posts)) {
      $view = View::make('sc.comm.partials.timeline.timeline_post_list', 
                          ['posts' => $posts]);
      $posts_html = $view->render();

      $result['nextPage'] = ++$page;
      $result['posts'] = $posts_html;
      // $result['posts'] = $posts;
    }

    return response()->json($result);
  }

}
