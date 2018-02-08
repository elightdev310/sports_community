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
use App\SC\Models\Photo;
use App\SC\Models\Node;
use App\SC\Models\NodeField;

use SCUserLib;
use SCPhotoLib;
use SCNodeLib;
use SCHelper;
use Exception;

/**
 * Class NodeController
 * @package App\Http\Controllers\SC\Comm
 */
class NodeController extends Controller
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
   * URL (/node/{node}/cover-photo)
   */
  public function coverPhotoPage(Request $request, Node $node)
  {
    $params = array();
    $params['node'] = $node;

    return view("sc.comm.node.cover_photo", $params);
  }

  /**
   * URL-POST (/node/{node}/cover-photo/upload)
   */
  public function uploadCoverPhoto(Request $request, Node $node)
  {
    try {
      $user = SCUserLib::currentUser();

      if (!$user) {
        return response()->json([
            "status" => "error",
            "action" => "reload_parent", 
          ], 200);
      }

      if(Input::hasFile('cover_photo')) {

        $file = Input::file('cover_photo');
        
        $photo_folder = "photos".DIRECTORY_SEPARATOR."node".DIRECTORY_SEPARATOR.$node->id;
        $photo = SCPhotoLib::uploadPhoto($file, $photo_folder, $node);
        $photo->used = 1;
        $photo->save();

        $result = SCNodeLib::saveNodeField($node->id, NodeField::FIELD_COVER_PHOTO_ID, $photo->id);

        if( $result ) {
          return response()->json([
            "status" => "success",
            "action" => "reload_parent"
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
            "action" => "reload_parent"
          ]);
    }
  }

  /**
   * URL-POST (/node/{node}/cover-photo/choose)
   */
  public function chooseCoverPhoto(Request $request, Node $node)
  {
    try {
      $user = SCUserLib::currentUser();

      if (!$user) {
        return response()->json([
            "status" => "error",
            "action" => "reload_parent", 
          ], 200);
      }

      $photo_id = $request->input('photo_id');
      $photo = Photo::find($photo_id);
      if ($photo) {
        $result = SCNodeLib::saveNodeField($node->id, NodeField::FIELD_COVER_PHOTO_ID, $photo->id);

        return response()->json([
          "status" => "success",
          "action" => "reload_parent"
        ]);
      } else {
        return response()->json([
          "status" => "error", 
          "message"=> "failed to upload photo."
        ]);
      }
    } catch(Exception $e) {
      return response()->json([
            "status" => "error", 
            "action" => "reload_parent"
          ]);
    }
  }
}
