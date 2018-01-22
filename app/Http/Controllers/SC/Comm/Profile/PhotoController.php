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

use SCUserLib;
use SCPhotoLib;
use SCHelper;
use Exception;

trait PhotoController {
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

      $files = Input::file('files');
      if($files) {
        foreach ($files as $file) {
          $photo_folder = "photos".DIRECTORY_SEPARATOR."user".DIRECTORY_SEPARATOR.$user->id;
          $photo = SCPhotoLib::uploadPhoto($file, $photo_folder, $user->getNode());
          $photo->used = 1;
          $photo->save(); 
        }
        return response()->json([
          "status" => "success",
          "action" => "reload"
        ], 200);
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
}
