<?php
namespace app\helpers;

use Yii;
use app\helpers\App;

class Element
{
    public static function nbsp($count=1)
    {
        $space = '';
        for ($i=0; $i < $count; $i++) { 
            $space .= "&nbsp;";
        }
        return $space;
    }

    public static function activateMenu($url)
    {
        $explode = explode("/", $url);
        $controller =  $explode[2] ?? '';
        if (App::isController($controller)) {
            return 'kt-menu__item--active';
        }
    }

    public static function navController($menu)
    {
        $controller = explode('/', $menu['link'])[3] ?? ''; 
        if (! $controller) {
            $controller = explode('/', $menu['link'])[1] ?? ''; 
        }
        return $controller;
    }
}