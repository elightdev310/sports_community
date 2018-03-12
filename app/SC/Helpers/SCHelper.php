<?php

namespace App\SC\Helpers;

use Auth;
use DB;
use Exception;
use App\SC\Models\User;

class SCHelper
{
    const DB_DATE_FORMAT = 'Y-m-d';
    /**
     * Formatted Error Message
     */
    public static function getErrorMessage($e)
    {
        $error = $e->getMessage()." <br/>in ".$e->getFile()." [Line: ".$e->getLine()."]";
        return $error;
    }

    public static function getMenuData($menu) 
    {
        $data = array();
        $user = Auth::user();

        if ($menu == 'admin' && $user->can('MICADMIN_PANEL')) {
            $data = config('menu.admin');
        } else {
            $data = config('menu.'.$menu);
        }

        return $data;
    }

    public static function printMenu($menu) 
    {
        $childrens = array();
        if (isset($menu['#child'])) {
            $childrens = $menu['#child'];
        }

        $treeview = "";
        $subviewSign = "";
        if(count($childrens)) {
            $treeview = " class=\"treeview\"";
            $subviewSign = '<i class="fa fa-angle-left pull-right"></i>';
        }

        $str = '<li'.$treeview.'>
                    <a href="'.url($menu['url']) .'">
                        <i class="fa '.$menu['icon'].'"></i> 
                        <span>'.$menu['title'].'</span> 
                        '.$subviewSign.'</a>';

        if(count($childrens)) {
            $str .= '<ul class="treeview-menu">';
            foreach($childrens as $children) {
                $str .= MICUILayoutHelper::printMenu($children);
            }
            $str .= '</ul>';
        }

        $str .= '</li>';

        return $str;
    }

    public static function printMenuTop($menu)
    {
        $childrens = array();
        if (isset($menu['#child'])) {
            $childrens = $menu['#child'];
        }

        $treeview = "";
        $treeview2 = "";
        $subviewSign = "";
        if(count($childrens)) {
            $treeview = " class=\"dropdown\"";
            $treeview2 = " class=\"dropdown-toggle\" data-toggle=\"dropdown\"";
            $subviewSign = ' <span class="caret"></span>';
        }

        $str = '<li '.$treeview.'>
        <a '.$treeview2.' href="'.url($menu['url']) .'">
            '.$menu['title'].$subviewSign.'</a>';

        if(count($childrens)) {
            $str .= '<ul class="dropdown-menu" role="menu">';
            foreach($childrens as $children) {
                $str .= MICUILayoutHelper::printMenuTop($children);
            }
            $str .= '</ul>';
        }
        $str .= '</li>';
        return $str;
    }

    public static function strDTime($dateTime) 
    {
        $date = date_create($dateTime);
        if (date_format($date, 'M d, Y') == date('M d, Y')) {
            $str = date_format($date, 'H:i');
        } else if (date_format($date, 'Y') == date('Y')) {
            $str = date_format($date, 'M d H:i');
        } else {
            $str = date_format($date, 'm/d/Y H:i');
        }

        return $str;
    }

    public static function getStrDate($dateTime, $type) {
        list($y, $m, $d) = explode('-', $dateTime);
        if ($type == 'y') { return $y; }
        else if ($type == 'm') { return $m; }
        else if ($type == 'd') { return $d; }
        return '';
    }
    public static function strTime($dateTime, $format="M d, Y") 
    {
        $date = date_create($dateTime);

        $str = '';
        $str = date_format($date, $format);

        return $str;
    }

    public static function duration($dur) 
    {
        $dt = new DateTime();
        $dt->add(new DateInterval($dur));
        $interval = $dt->diff(new DateTime());
        return $interval->format('%I:%S');
    }
    public static function agoTime($datetime, $suffix='') 
    {
        if (is_string($datetime)) {
            $datetime = date_create($datetime);
        }
        $interval = date_create('now')->diff( $datetime );
        if ( $v = $interval->y >= 1 ) { return $interval->y.' '.str_plural('year',   $interval->y).$suffix; }
        if ( $v = $interval->m >= 1 ) { return $interval->m.' '.str_plural('month',  $interval->m).$suffix; }
        if ( $v = $interval->d >= 1 ) { return $interval->d.' '.str_plural('day',    $interval->d).$suffix; }
        if ( $v = $interval->h >= 1 ) { return $interval->h.' '.str_plural('hour',   $interval->h).$suffix; }
        if ( $v = $interval->i >= 1 ) { return $interval->i.' '.str_plural('minute', $interval->i).$suffix; }
        if ( $interval->s == 0 ) {
            return 'Just now';
        }
        return $interval->s.' '.str_plural('second', $interval->s).$suffix;
    }

    public static function monthArray() {
        $data = array();
        $data['']    = '- Please select month -';
        $data['1']  = 'January';
        $data['2']  = 'Feburary';
        $data['3']  = 'March';
        $data['4']  = 'April';
        $data['5']  = 'May';
        $data['6']  = 'June';
        $data['7']  = 'July';
        $data['8']  = 'August';
        $data['9']  = 'September';
        $data['10'] = 'October';
        $data['11'] = 'November';
        $data['12'] = 'December';

        return $data;
    }
    public static function dayArray() {
        $data = array();
        $data['']    = '- Please select day -';
        for ($day = 1; $day<=31; $day++) {
            $data[$day] = $day;
        }
        return $data;
    }
    public static function yearArray() {
        $data = array();
        $data['']    = '- Please select year -';
        for ($year = date('Y'); $year>=date('Y')-70; $year--) {
            $data[$year] = $year;
        }
        return $data;
    }

    /**
     * Create Slug - Machine Name
     */
    public static function createSlug($name, $table) {
        $slug = str_slug($name,'-');
        try {
            $repeating = 0;
            while (self::checkSlugExist($slug, $table)) {
                $repeating++;
                if ($repeating < 10000) {
                    $slug = str_slug($name,'-').mt_rand(0, 99999);
                } else {
                    $slug = str_slug($name.str_random(5),'-').mt_rand(0, 99999);
                }
            }
            return $slug;
        } catch(Exception $e) {
            return false;
        }
    }
    public static function checkSlugExist($slug, $table) {
        $count = DB::table($table)->where('slug', $slug)->count();
        if ($count) {
            return true;
        }
        return false;
    }

    /**
     * Get Object ID by Slug
     */
    public static function getObjectIDBySlug($slug, $table) {
        try {
            $obj = DB::table($table)->where('slug', $slug)->first();
            if ($obj && isset($obj->id)) {
                return $obj->id;
            }
        } catch(Exception $e) {
            return 0;
        }
        return 0;
    }
}
