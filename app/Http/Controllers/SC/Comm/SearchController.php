<?php
/**
 *
 */

namespace App\Http\Controllers\SC\Comm;

use Auth;
use Validator;
use Mail;
use DB;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;

use App\SC\Models\User;
use App\SC\Models\Node;
use SCUserLib;
use SCHelper;

use Exception;

/**
 * Class ProfileController
 * @package App\Http\Controllers\SC\Comm
 */
class SearchController extends Controller
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
   * URL (/search/people)
   */
  public function people(Request $request) 
  {
    $currentUser = SCUserLib::currentUser();
    $params = array();
    $query = '';
    if ($request->has('q')) {
      $query = $request->input('q');
      $result = DB::table('users')
                  ->select('users.*')
                  ->where('type', '=', config('sc.user_type.app_user'))
                  ->where('status', '=', config('sc.user_status.active'))
                  ->where(function ($q) use($query) {
                     $q->where('name', 'LIKE', "%".$query."%");
                  })
                   ->get();
      $params['result'] = $result;
    } else {
      $params['no_query'] = true;
    }
    
    $params['query'] = $query;
    return view('sc.comm.search.people', $params);
  }
}
