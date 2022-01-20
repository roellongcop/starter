<?php

namespace app\helpers;

use Yii;
use app\helpers\App;
use app\models\File;
use app\widgets\Anchor;

class Url extends \yii\helpers\Url
{
    public static function image($token='', $params = [], $scheme=false)
    {
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