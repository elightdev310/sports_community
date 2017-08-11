<?php

namespace App\SC\Libs;

use DB;
use Auth;

use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

use App\Role;
use App\SC\Models\User;

Trait UserLib_Helper
{
    /**
     * Get Current User 
     * @return: User (SC Model)
     */
    public function currentUser() {
        $user = Auth::user();
        return $user;
    }

    public function avatarImage($user, $size=160, $classes="") {
        if (is_numeric($user)) {
            $user = User::find($user);
        }
        
        if (!$user->avatar) {
          $user->avatar = 'default.jpg';
        }
        $avatar_url = url(config('sc.avatar_path') . $user->avatar);

        $html = sprintf('<img src="%s" class="%s img profile-picture" width="%d" height="%d" alt="User Image">', 
                         $avatar_url, $classes, $size, $size);
        return $html;
    }
    public function checkAvatarExist($user) {
        if (is_numeric($user)) {
            $user = User::find($user);
        }
        if (!$user->avatar || $user->avatar=='default.jpg') {
            return false;
        }
        return true;
    }

    public static function isSuperAdmin($user) 
    {
        if (is_numeric($user)) {
            $user = User::find($user);
        }

        if ($user->hasRole(config('sc.user_role.super_admin'))) {
            return true;
        } else {
            return false;
        }
    }

    public static function isAdmin($user) 
    {
        if (is_numeric($user)) {
            $user = User::find($user);
        }

        if ($user->hasRole(config('sc.user_role.web_admin'))) {
            return true;
        } else {
            return false;
        }
    }

    public static function getUserType($user) {
        $user_type = '';
        switch ($user->type) {
            case config('sc.user_type.employee'):
                $user_type = "Employee"; break;
            case config('sc.user_type.app_user'):
                $user_type = "App User"; break;
        }
        return $user_type;
    }
}
