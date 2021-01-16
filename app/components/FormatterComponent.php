<?php
namespace app\components;

use app\helpers\App;
use yii\helpers\Inflector;

class FormatterComponent extends \yii\i18n\Formatter
{
    public function asStripTags($value)
    {
        return strip_tags($value);
    }

    public function asAgo($value)
    {
        return App::ago($value);
    }

    public function asFulldate($value)
    {
        return App::date_timezone($value);
    }

    public function asController2Menu($value)
    {
        return ucwords(
            str_replace('-', ' ', Inflector::titleize($value))
        );
    }
}