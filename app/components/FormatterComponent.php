<?php
namespace app\components;

use app\helpers\App;
use app\widgets\JsonEditor;
use yii\helpers\Inflector;
use yii\helpers\Json;

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

    public function asBoolString($value)
    {
        return $value ? 'True': 'False';
    }

    public function asEncode($value)
    {
        return Json::encode($value);
    }

    public function asDecode($value)
    {
        return Json::decode($value, true);
    }

    public function asJsonEditor($value)
    {
        return JsonEditor::widget([
            'data' => $value,
        ]);
    }
}