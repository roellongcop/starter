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

    public static function navController($link)
    {
        $request = new Request([
            'url' => parse_url(\yii\helpers\Url::to($link, true), PHP_URL_PATH)
        ]);
        $url = App::urlManager()->parseRequest($request);
        list($controller, $actionID) = App::app()->createController($url[0]);

        return $controller ? $controller->id: '';
    }

    public static function image($token, $params=[], $options=[])
    {
        return parent::img(Url::image($token, $params), $options);
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