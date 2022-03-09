<?php

namespace app\helpers;

use Yii;
use app\helpers\App;
use app\helpers\Url;
use app\widgets\Anchor;
use yii\web\Request;
use app\widgets\ExportButton;
use app\widgets\Anchors;

class Html extends \yii\helpers\Html
{
    public static function a($text, $url = null, $options = [])
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

    public static function download($token, $params=[], $options=[])
    {
        return parent::img(Url::download($token, $params), $options);
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

    public static function if($condition = true, $content='', $params=[])
    {
        if ($condition) {
            if (is_callable($content)) {
                return call_user_func($content, $params);
            }
            return $content;
        }
    }

    public static function ifELse($condition = true, $trueContent='', $falseContent='', $params=[])
    {
        if ($condition) {
            if (is_callable($trueContent)) {
                return call_user_func($trueContent, $params);
            }

            return $trueContent;
        }

        if (is_callable($falseContent)) {
            return call_user_func($falseContent, $params);
        }
        return $falseContent;
    }

    public static function ifElseIf($arr=[], $params=[])
    {
        if ($arr) {
            foreach ($arr as $key => $data) {
                if ($data['condition']) {
                    if (is_callable($data['content'])) {
                        return call_user_func($data['content'], $params);
                    }
                    return $data['content'];
                }
            }
        }
    }

    public static function foreach($array=[], $function, $glue=' ')
    {
        $content = [];
        foreach ($array as $key => $value) {
            $content[] = call_user_func($function, $value, $key);
        }

        return implode($glue, $content);
    }


    public static function content($content, $params)
    {
        if ($params['wrapCard'] ?? true) {
            return App::view()->render('_card_wrapper-container', [
                'content' => $content
            ]);
        }

        return $content;
    }

    public static function exportButton($params)
    {
        if ($params['showExportButton'] ?? '') {
            return ExportButton::widget();
        }
    }

    public static function createButton($params)
    {
        if ($params['showCreateButton'] ?? '') {
            return Anchors::widget([
                'names' => 'create',
                'controller' => $params['createController'] ?? App::controllerID(),
            ]);
        }
    }

    public static function advancedFilter($searchModel)
    {
        if ($searchModel) {
            $searchTemplate = $searchModel->searchTemplate ?? implode('/', [
                App::controllerID(),
                '_search'
            ]);

            return App::view()->render("/{$searchTemplate}", [
                'model' => $searchModel,
            ]);
        }
    }
}