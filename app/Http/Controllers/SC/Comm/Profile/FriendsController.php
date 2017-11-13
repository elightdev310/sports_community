<?php
/**
 * 
 */

namespace App\Http\Controllers\SC\Comm\Profile;


use Auth;
use Validator;
use Mail;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

use Illuminate\Support\Facades\Input;

use App\SC\Models\User;
use App\SC\Models\FriendRequest;
use App\SC\Models\FriendShip;

use SCUserLib;
use SCHelper;
use Exception;

trait FriendsController {
  public function friendsPage(Request $request, User $user)
  {
    if ($user->status != config('sc.user_status.active')) {
      abort(404);
    }

    $currentUser = SCUserLib::currentUser();

    $params = array();
    $params['user'] = $user;
    $params['tab'] = 'friends';
    $params['profile'] = $user->profile;
    $params['friends'] = SCUserLib::getFriends($user->id);
    $params['editable'] = ($currentUser->id == $user->id)? 1 : 0;

    return view('sc.comm.profile.friends.friends', $params);
  }

  /**
   * URL-POST (profile/{user}/friends/send-request)
   */
  public function sendFriendReuqest(Request $request, User $user)
  {
    try {
      $currentUser = SCUserLib::currentUser();
      if (!$user || $currentUser->id == $user->id) {
        throw new Exception('Failed to send request. Please refresh page and try again.');
      }
      if (SCUserLib::getFriendRequests($user->id)) {
        return response()->json([
            "status" => "error",
            "action" => "reload", 
          ]);
      }
      $fr = FriendRequest::create([
        'user_id'     => $currentUser->id, 
        'friend_uid'  => $user->id, 
      ]);
      return response()->json([
            "status" => "success",
            "action" => "reload", 
          ]);
    } catch(Exception $e) {
      return response()->json([
            "status" => "error",
            "message" => SCHelper::getErrorMessage($e), 
          ]);
    }
  }

  /**
   * URL-POST (profile/{user}/friends/cancel-request)
   */
  public function cancelFriendReuqest(Request $request, User $user)
  {
    try {
      $currentUser = SCUserLib::currentUser();
      if (!$user || $currentUser->id == $user->id) {
        throw new Exception('Failed to cancel request. Please refresh page and try again.');
      }

      $fr = SCUserLib::getFriendRequests($user->id);
      if (!$fr || $fr->user_id != $currentUser->id) {
        return response()->json([
            "status" => "error",
            "action" => "reload", 
          ]);
      }
      $fr->forceDelete();
      return response()->json([
            "status" => "success",
            "action" => "reload", 
          ]);
    } catch(Exception $e) {
      return response()->json([
            "status" => "error",
            "message" => SCHelper::getErrorMessage($e), 
          ]);
    }
  }

  /**
   * URL-POST (profile/{user}/friends/confirm-request)
   */
  public function confirmFriendReuqest(Request $request, User $user)
  {
    try {
      $currentUser = SCUserLib::currentUser();
      if (!$user || $currentUser->id == $user->id) {
        throw new Exception('Failed to confirm request. Please refresh page and try again.');
      }

      $fr = SCUserLib::getFriendRequests($user->id);
      if (!$fr || $fr->friend_uid != $currentUser->id) {
        return response()->json([
            "status" => "error",
            "action" => "reload", 
          ]);
      }
      $fr->forceDelete();
      $fs = FriendShip::create([
        'user1_id'  => $user->id, 
        'user2_id'  => $currentUser->id 
      ]);

      return response()->json([
            "status" => "success",
            "action" => "reload", 
          ]);
    } catch(Exception $e) {
      return response()->json([
            "status" => "error",
            "message" => SCHelper::getErrorMessage($e), 
          ]);
    }
  }
  /**
   * URL-POST (profile/{user}/friends/reject-request)
   */
  public function rejectFriendReuqest(Request $request, User $user)
  {
    try {
      $currentUser = SCUserLib::currentUser();
      if (!$user || $currentUser->id == $user->id) {
        throw new Exception('Failed to reject request. Please refresh page and try again.');
      }

      $fr = SCUserLib::getFriendRequests($user->id);
      if (!$fr || $fr->friend_uid != $currentUser->id) {
        return response()->json([
            "status" => "error",
            "action" => "reload", 
          ]);
      }
      $fr->forceDelete();
      return response()->json([
            "status" => "success",
            "action" => "reload", 
          ]);
    } catch(Exception $e) {
      return response()->json([
            "status" => "error",
            "message" => SCHelper::getErrorMessage($e), 
          ]);
    }
  }

  public function closeFriendShip(Request $request, User $user)
  {
    try {
      $currentUser = SCUserLib::currentUser();
      if (!$user || $currentUser->id == $user->id) {
        throw new Exception('Failed to close request. Please refresh page and try again.');
      }

      SCUserLib::closeFriendShip($currentUser->id, $user->id);

      return response()->json([
            "status" => "success",
            "action" => "reload", 
          ]);
    } catch(Exception $e) {
      return response()->json([
            "status" => "error",
            "message" => SCHelper::getErrorMessage($e), 
          ]);
    }
  }
}
