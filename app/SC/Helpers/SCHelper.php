<?php

namespace App\SC\Helpers;

use Auth;
use App\SC\Models\User;

class SCHelper
{
    /**
     * Formatted Error Message
     */
    public static function getErrorMessage($e)
    {
        $error = $e->getMessage()."in ".$e->getFile()."[Line: ".$e->getLine."]";
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
}
