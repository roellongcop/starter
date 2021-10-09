<?php

namespace app\helpers;

use Yii;
use app\helpers\App;
use app\models\File;

class Url extends \yii\helpers\Url
{
    public static function image($token='', $params = [], $scheme=false)
    {
        $file = File::findByToken($token) ?: File::findByToken(App::setting('image')->image_holder);

        if ($file) {
            return $file->getDisplay($params, $scheme);
        }

        return $token ?: File::IMAGE_HOLDER;
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