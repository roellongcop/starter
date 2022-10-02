<?php

namespace app\helpers;

use Yii;
use app\helpers\App;
use app\models\File;
use app\widgets\Anchor;

class Url extends \yii\helpers\Url
{
    public static function image($token='', $params = [], $scheme=false, $displayPath=false)
    {
        $file = is_object($token)? $token: File::findByToken($token);

        if ($file && file_exists($file->displayRootPath)) { 
            // code...
        }
        else {
            $file = File::findByToken(App::setting('image')->image_holder);
        }

        if ($file && file_exists($file->displayRootPath)) {

            return App::component('imageResize')->getUrl(
                $file->displayRootPath, 
                (($params['w'] ?? ($file->width ?: 100)) ?: 100), 
                (($params['h'] ?? ($file->height ?: 100)) ?: 100), 
                'inset', 
                $params['quality'] ?? 90,
                null,
                $file->location
            );
        }

        // if ($displayPath) {
        //     $file = File::findByToken($token);
        //     return $file ? $file->displayPath: '';
        // }
        return self::to(array_merge(['file/display', 'token' => $token], $params), $scheme);
    }

    public static function download($token='', $scheme=false)
    {
        return self::to(['file/download', 'token' => $token], $scheme);
    }

    public static function to($url = '', $scheme = false)
    {
        if (! App::isWeb()) {
            if ($scheme) {
                return Yii::$app->urlManager->createAbsoluteUrl($url);
            }
            else {
                return Yii::$app->urlManager->createUrl($url);
            }
        }

        return parent::to($url, $scheme);
    }

    public static function userCanRoute($link)
    {
        $anchor = Anchor::widget(['link' => $link]);

        return $anchor ? true: false;
    }
}