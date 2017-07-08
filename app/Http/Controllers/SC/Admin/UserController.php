<?php
/**
 *
 */

namespace App\Http\Controllers\SC\Admin;

use Auth;
use Validator;
use Mail;
use Input;
use DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Http\Requests;
use App\Http\Controllers\Controller as Controller;

use App\User as AuthUser;
use App\Role;
use App\SC\Models\User;


/**
 * Class UserController
 * @package App\Http\Controllers\SC\Admin
 */
class UserController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */

    const PAGE_LIMIT = 10;

    public function userListPage(Request $request)
    {
        $q = DB::table('users')->select('users.*');

        if ($request->has('user_type')) {
            $q->where('users.type', $request->input('user_type'));
        }
        if ($request->has('status')) {
            $q->where('users.status', $request->input('status'));
        }
        if ($request->has('search_txt')) {
            $search_txt = trim($request->input('search_txt'));

            if ($search_txt) {
                $q->where(function($query) use ($search_txt) {
                    $query->where('users.name', 'like', '%'.$search_txt.'%')
                          ->orWhere('users.email', 'like', '%'.$search_txt.'%');
                });
            }
        }

        $paginate = $q->orderBy('created_at', 'DESC')
                      ->paginate(self::PAGE_LIMIT);

        $users = array();

        foreach ($paginate as $record) {
          $users[] = User::find($record->id);
        }

        $params = array();
        $params['users'] = $users;
        $params['paginate'] = $paginate;

        return view('sc.admin.user.list', $params);
    }
}
