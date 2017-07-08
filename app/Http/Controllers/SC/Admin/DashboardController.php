<?php
/**
 *
 */

namespace App\Http\Controllers\SC\Admin;

use Auth;
use Validator;
use Mail;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

/**
 * Class DashboardController
 * @package App\Http\Controllers\MIC\Admin
 */
class DashboardController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    
  }

  public function index(Request $request)
  {

    $params = array();
    return view('sc.admin.dashboard', $params);
  }
  
}
