<?php

namespace app\helpers;

use Yii;
use app\helpers\App;
use app\models\File;

class Url extends \yii\helpers\Url
{
    public static function image($token='', $params = [], $scheme=false)
    {
        $token = $token ?: App::setting('image')->image_holder;
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
}