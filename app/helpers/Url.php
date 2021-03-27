<?php
namespace app\helpers;

use Yii;
use app\helpers\App;

class Url extends \yii\helpers\Url
{
    public static function imagePath($path, $params = [])
    {
        if ($params) {
            return implode('&', [
                $path,
                http_build_query($params)
            ]);
        }

        return $path;
    }
}