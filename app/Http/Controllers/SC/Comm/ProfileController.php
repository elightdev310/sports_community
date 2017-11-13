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

use App\SC\Models\User;
use App\SC\Models\UserProfile;
use App\SC\Models\Education;
use App\SC\Models\FriendRequest;
use App\SC\Models\FriendShip;

use SCUserLib;
use SCPhotoLib;
use SCHelper;
use Exception;

/**
 * Class ProfileController
 * @package App\Http\Controllers\SC\Comm
 */
class ProfileController extends Controller
{
  use Profile\FriendsController, 
      Profile\AboutController, 
      Profile\PhotoController;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    
  }

  /**
   * URL (/profile/{user})
   * 
   * User Timeline Page
   */
  public function profilePage(Request $request, User $user)
  {
    if ($user->status != config('sc.user_status.active')) {
      abort(404);
    }
    
    if (!$user->profile) {
        $user->createProfile();
    }

    $currentUser = SCUserLib::currentUser();

    $params = array();
    $params['tab'] = 'timeline';

    $params['user'] = $user;
    $params['profile'] = $user->profile;

    $params['node'] = $user->getNode();
    $params['posts_url'] = route('timeline.load_post', 
                                 ['group'=>$params['node'], 'type'=>'timeline']);
    $params['editable'] = ($currentUser->id == $user->id)? 1 : 0;

    return view('sc.comm.profile.timeline', $params);
  }

  /**
   * URL (/profile/avatar)
   */
  public function avatarPage(Request $request)
  {
    $params = array();

    return view("sc.comm.profile.avatar", $params);
  }

  /**
   * URL-POST (/profile/avatar/upload)
   */
  public function uploadAvatar(Request $request)
  {
    try {
      $_user = SCUserLib::currentUser();
      $user = User::find($_user->id);

      if (!$user) {
        return response()->json([
            "status" => "error",
            "action" => "reload", 
          ], 200);
      }

      $filename = snake_case($user->name). time() . '.png';
      $fullpath = public_path(config('sc.avatar_path') . $filename);
      
      // Save Base64 Image data
      $img = $request->input('user_pic');
      $img = str_replace('data:image/png;base64,', '', $img);
      $img = str_replace(' ', '+', $img);
      $data = base64_decode($img);
      file_put_contents($fullpath, $data);

      // Remove old picture
      if ($user->avatar && $user->avatar!='default.jpg') {
        $old_picture = public_path(config('sc.avatar_path') . $user->avatar);
        if (file_exists($old_picture)) {
          unlink( $old_picture );
        }
      }

      $user->avatar = $filename;
      $user->save();

      return response()->json([
            "status" => "success",
            "action" => "reload_parent", 
          ], 200);
    } catch(Exception $e) {
      return response()->json([
            "status" => "error",
            "action" => "reload_parent", 
          ], 200);
    }
  }

  /**
   * URL (/profile/cover-photo)
   */
  public function coverPhotoPage(Request $request)
  {
    $params = array();

    return view("sc.comm.profile.cover_photo", $params);
  }

  /**
   * URL-POST (/profile/cover-photo/upload)
   */
  public function uploadCoverPhoto(Request $request)
  {
    try {
      $_user = SCUserLib::currentUser();
      $user = User::find($_user->id);

      if (!$user) {
        return response()->json([
            "status" => "error",
            "action" => "reload", 
          ], 200);
      }

      if(Input::hasFile('cover_photo')) {

        $file = Input::file('cover_photo');
        
        $photo_folder = "photos".DIRECTORY_SEPARATOR."user".DIRECTORY_SEPARATOR.$user->id;
        $photo = SCPhotoLib::uploadPhoto($file, $photo_folder, $user->getNode());
        $photo->used = 1;
        $photo->save();

        $profile = $user->profile;
        $profile->cover_photo_id = $photo->id;
        $profile->save();

        if( $photo ) {
          return response()->json([
            "status" => "success",
            "action" => "reload"
          ]);
        } else {
          return response()->json([
            "status" => "error", 
            "message"=> "failed to upload photo."
          ]);
        }
      } else {
        return response()->json([
            "status" => "error", 
            "message"=> "upload file not found."
          ]);
      }
    } catch(Exception $e) {
      return response()->json([
            "status" => "error", 
            "action" => "reload"
          ]);
    }
  }
}
