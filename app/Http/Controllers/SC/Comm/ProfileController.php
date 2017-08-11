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

use App\SC\Models\User;
use SCUserLib;

/**
 * Class ProfileController
 * @package App\Http\Controllers\SC\Comm
 */
class ProfileController extends Controller
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
   * URL (/profile)
   */
  public function profilePage(Request $request)
  {
    $user = SCUserLib::currentUser();

    $params = array();
    $params['tab'] = 'timeline';
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
   * URL-POST (/profile/avatar/save)
   */
  public function saveAvatar(Request $request)
  {
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
  }
  
}
