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
use App\SC\Models\UserProfile;
use App\SC\Models\Education;

use SCUserLib;
use SCHelper;
use Exception;

trait AboutController {
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
}
