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
use SCUserLib;
use SCPhotoLib;
use Exception;

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
   * URL (/profile/{user})
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
    $params['user'] = $user;
    $params['tab'] = 'timeline';
    $params['profile'] = $user->profile;
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
        $folder = storage_path($photo_folder);
        $photo = SCPhotoLib::uploadPhoto($file, $folder, $user->getNode());
        $photo->used = 1;
        $photo->save();

        $profile = $user->profile;
        $profile->cover_photo_id = $photo->id;
        $profile->save();

        if( $photo ) {
          return response()->json([
            "status" => "success",
            "action" => "reload"
          ], 200);
        } else {
          return response()->json([
            "status" => "error", 
            "message"=> "failed to upload photo."
          ], 200);
        }
      } else {
        return response()->json([
            "status" => "error", 
            "message"=> "upload file not found."
          ], 200);
      }
    } catch(Exception $e) {
      return response()->json([
            "status" => "error", 
            "action" => "reload"
          ], 200);
    }
  }

  /**
   * URL (/profile/{user}/photos)
   */
  public function photoPage(Request $request, User $user) 
  {
    if ($user->status != config('sc.user_status.active')) {
      abort(404);
    }

    $currentUser = SCUserLib::currentUser();

    $params = array();
    $params['user'] = $user;
    $params['tab'] = 'photos';
    $params['photos'] = SCPhotoLib::getPhotos($user->getNode());
    $params['editable'] = ($currentUser->id == $user->id)? 1 : 0;

    return view('sc.comm.profile.photo', $params);
  }

  /**
   * URL-POST (/profile/{user}/photo/upload)
   */
  public function uploadPhoto(Request $request, User $user) 
  {
    try {
      $_user = SCUserLib::currentUser();

      if ($user->id != $_user->id) {
        return response()->json([
            "status" => "error",
            "action" => "reload", 
          ], 200);
      }

      if(Input::hasFile('file')) {

        $file = Input::file('file');
        
        $photo_folder = "photos".DIRECTORY_SEPARATOR."user".DIRECTORY_SEPARATOR.$user->id;
        $folder = storage_path($photo_folder);
        $photo = SCPhotoLib::uploadPhoto($file, $folder, $user->getNode());
        $photo->used = 1;
        $photo->save();
        
        if( $photo ) {
          return response()->json([
            "status" => "success",
            "action" => "reload"
          ], 200);
        } else {
          return response()->json([
            "status" => "error", 
            "message"=> "failed to upload photo."
          ], 200);
        }
      } else {
        return response()->json([
            "status" => "error", 
            "message"=> "upload file not found."
          ], 200);
      }
    } catch(Exception $e) {
      return response()->json([
            "status" => "error", 
            "action" => "reload"
          ], 200);
    }
  }

  /**
   * URL-POST (/profile/{user}/photo/delete)
   */
  public function deletePhoto(Request $request, User $user) {
    $_user = SCUserLib::currentUser();

    if ($user->id != $_user->id) {
      return response()->json([
          "status" => "error",
          "action" => "reload", 
        ], 200);
    }

    $photo_id = $request->input('photo_id');
    if (SCPhotoLib::removePhoto($photo_id)) {
      return response()->json([
          "status" => "success",
          "action" => "reload"
        ], 200);
    } else {
      return response()->json([
          "status" => "error", 
          "action" => "reload"
        ], 200);
    }
  }
  
  /**
   * URL (/profile/{user}/about/contact)
   */
  public function aboutContactPage(Request $request, User $user)
  {
    if ($user->status != config('sc.user_status.active')) {
      abort(404);
    }
    
    if (!$user->profile) {
        $user->createProfile();
    }

    $currentUser = SCUserLib::currentUser();

    $params = array();
    $params['user'] = $user;
    $params['tab'] = 'about';
    $params['about_tab'] = 'contact';
    $params['profile'] = $user->profile;
    $params['editable'] = ($currentUser->id == $user->id)? 1 : 0;

    return view('sc.comm.profile.about_contact', $params);
  }

  /**
   * URL-POST (/profile/{user}/about/contact)
   */
  public function saveContact(Request $request, User $user) {
    try {
      $_user = SCUserLib::currentUser();

      if ($user->id != $_user->id) {
        throw new Exception();
      }

      $profile = $user->profile;
      $profile->phone   = $request->input('phone');
      $profile->address = $request->input('address');
      $profile->city    = $request->input('city');
      $profile->state   = $request->input('state');
      $profile->zip     = $request->input('zip');
      $profile->save();
      
      return redirect()->back();
    } catch(Exception $e) {
      return redirect()->back()->withErrors('Failed to save contact information.');
    }
  }

  /**
   * URL (/profile/{user}/about/basic)
   */
  public function aboutBasicPage(Request $request, User $user)
  {
    if ($user->status != config('sc.user_status.active')) {
      abort(404);
    }
    
    if (!$user->profile) {
        $user->createProfile();
    }

    $currentUser = SCUserLib::currentUser();

    $params = array();
    $params['user'] = $user;
    $params['tab'] = 'about';
    $params['about_tab'] = 'basic';
    $params['profile'] = $user->profile;
    $params['editable'] = ($currentUser->id == $user->id)? 1 : 0;
    $params['sub_message'] = true;

    return view('sc.comm.profile.about_basic', $params);
  }

  /**
   * URL-POST (/profile/{user}/about/basic)
   */
  public function saveBasic(Request $request, User $user) {
    try {
      $_user = SCUserLib::currentUser();

      if ($user->id != $_user->id) {
        throw new Exception();
      }

      $validator = Validator::make($request->all(), [
        'birth_year'   => 'required', 
        'birth_month'  => 'required', 
        'birth_day'    => 'required', 
        'gender'    => 'required', 
      ]);

      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
      }
      $profile = $user->profile;
      $profile->date_birth = sprintf("%d-%02d-%02d", 
            $request->input('birth_year'), 
            $request->input('birth_month'), 
            $request->input('birth_day'));
      $profile->gender = $request->input('gender');
      $profile->save();

      return redirect()->back();

    } catch(Exception $e) {
      return redirect()->back()->withErrors('Failed to save contact information.')->withInput();
    }
  }

  /**
   * URL (/profile/{user}/about/education)
   */
  public function aboutEducationPage(Request $request, User $user)
  {
    if ($user->status != config('sc.user_status.active')) {
      abort(404);
    }
    
    if (!$user->profile) {
        $user->createProfile();
    }

    $currentUser = SCUserLib::currentUser();

    $params = array();
    $params['user'] = $user;
    $params['tab'] = 'about';
    $params['about_tab'] = 'education';
    $params['profile'] = $user->profile;
    $params['editable'] = ($currentUser->id == $user->id)? 1 : 0;

    return view('sc.comm.profile.about_education', $params);
  }
}
