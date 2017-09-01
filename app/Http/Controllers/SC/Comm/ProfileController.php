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
    $params['tab'] = 'timeline';

    $params['user'] = $user;
    $params['profile'] = $user->profile;

    $params['node'] = $user->getNode();
    $params['posts'] = $user->getPosts();
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
          ]);
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

  /**
   * URL-POST (/profile/{user}/photo/delete)
   */
  public function deletePhoto(Request $request, User $user) {
    $_user = SCUserLib::currentUser();

    if ($user->id != $_user->id) {
      return response()->json([
          "status" => "error",
          "action" => "reload", 
        ]);
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
        ]);
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

    return view('sc.comm.profile.about.contact', $params);
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

    return view('sc.comm.profile.about.basic', $params);
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

    $educations = Education::where('user_id', '=', $user->id)
                      ->orderBy('start', 'ASC')
                      ->get();

    $params = array();
    $params['user'] = $user;
    $params['tab'] = 'about';
    $params['about_tab'] = 'education';
    $params['profile'] = $user->profile;
    $params['educations'] = $educations;
    $params['editable'] = ($currentUser->id == $user->id)? 1 : 0;

    return view('sc.comm.profile.about.education', $params);
  }

  /**
   * URL (/profile/{user}/about/education/add)
   */
  public function addEducationPage(Request $request, User $user)
  {
    $currentUser = SCUserLib::currentUser();

    $params = array();
    $params['user'] = $user;
    $params['tab'] = 'about';
    $params['about_tab'] = 'education';
    $params['profile'] = $user->profile;
    $params['editable'] = ($currentUser->id == $user->id)? 1 : 0;

    return view('sc.comm.profile.education.add', $params);
  }

  /**
   * URL-POST (/profile/{user}/about/education/add)
   */
  public function addEducation(Request $request, User $user)
  {
    $validator = Validator::make($request->all(), [
        'name'   => 'required', 
        'start_year'  => 'required', 
      ]);

    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }

    $start = $end = "0000-00-00";
    $start = $request->input('start_year').'-00-00';
    if ($request->input('end_year')) {
      $end = $request->input('end_year').'-00-00';
    }
    $graduated = $request->has('graduated')? 1:0;

    $edu = Education::create([
        'name'      => $request->input('name'), 
        'start'     => $start, 
        'end'       => $end, 
        'graduated' => $graduated, 
        'user_id'   => $user->id
      ]);

    return redirect()->back()->withInput()->with('redirect', '_parent');
  }

  /**
   * URL (/profile/{user}/about/education/{edu}/edit)
   */
  public function editEducationPage(Request $request, User $user, Education $edu)
  {
    $currentUser = SCUserLib::currentUser();

    $params = array();
    $params['user'] = $user;
    $params['tab'] = 'about';
    $params['about_tab'] = 'education';
    $params['profile'] = $user->profile;
    $params['education'] = $edu;
    $params['editable'] = ($currentUser->id == $user->id)? 1 : 0;

    return view('sc.comm.profile.education.edit', $params);
  }

  /**
   * URL-POST (/profile/{user}/about/education/{edu}/edit)
   */
  public function editEducation(Request $request, User $user, Education $edu)
  {
    $currentUser = SCUserLib::currentUser();
    if ($currentUser->id != $user->id || $user->id != $edu->user_id) {
      return redirect()->back()->withInput()->with('redirect', '_parent');
    }

    $validator = Validator::make($request->all(), [
        'name'   => 'required', 
        'start_year'  => 'required', 
      ]);

    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }

    $start = $end = "0000-00-00";
    $start = $request->input('start_year').'-00-00';
    if ($request->input('end_year')) {
      $end = $request->input('end_year').'-00-00';
    }
    $graduated = $request->has('graduated')? 1:0;

    $edu->name  = $request->input('name');
    $edu->start = $start;
    $edu->end   = $end;
    $edu->graduated = $graduated;
    $edu->save();

    return redirect()->back()->withInput()->with('redirect', '_parent');
  }

  /**
   * URL-POST (/profile/{user}/about/education/delete)
   */
  public function deleteEducation(Request $request, User $user)
  {
    try {
      if (!$request->has('edu_id')) {
        return response()->json([
            "status" => "error",
            "action" => "reload", 
          ]);
      }
      $edu_id = $request->input('edu_id');
      $edu = Education::find($edu_id);
      if (!$edu) {
        return response()->json([
            "status" => "error",
            "action" => "reload", 
          ]);
      }
      $edu->forceDelete();
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
