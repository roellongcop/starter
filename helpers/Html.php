<?php
namespace app\helpers;

use Yii;
use app\helpers\App;
use app\helpers\Url;
use app\widgets\Anchor;
use yii\web\Request;

class Html extends \yii\helpers\Html
{
    public static function a($text, $url = NULL, $options = [])
    {
        return Anchor::widget([
            'title' => $text ,
            'link' => $url,
            'options' => $options,
        ]);
    }
    
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
        $request = new Request(['url' => parse_url(Url::to($menu['link'], true), PHP_URL_PATH)]);
        $url = App::urlManager()->parseRequest($request);
        list($controller, $actionID) = App::app()->createController($url[0]);

        return $controller ? $controller->id: '';

        // $request = new Request(['url' => parse_url(Url::to($menu['link'], true), PHP_URL_PATH)]);
        // $current = App::urlManager()->parseRequest($request)[0] ?? '';

        // if ($current && is_array($current)) {
        //     list($controller, $action) = explode('/', $current);

        //     return $controller;
        // }

        
        // $controller = explode('/', $menu['link'])[3] ?? ''; 
        // if (! $controller) {
        //     $controller = explode('/', $menu['link'])[1] ?? ''; 
        // }
        // return $controller;
    }

    public static function image($path, $params=[], $options=[])
    {
        return parent::img(Url::imagePath($path, $params), $options);
    }

    public static function isHtml($string)
    {
        if($string != strip_tags($string)) {
            // is HTML
            return true;
        }
        else {
            // not HTML
            return false;
        }
    }
}