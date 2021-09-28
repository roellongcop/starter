<?php

namespace app\models\form\setting;

use Yii;
use app\models\Setting;
use yii\helpers\ArrayHelper;

abstract class SettingForm extends \yii\base\Model
{
    public abstract function default();
    
    public function init()
    {
        parent::init();
        $data = ArrayHelper::map($this->default(), 'name', 'default');

        if (($model = Setting::findByName(static::NAME)) != NULL) {
            $data = array_replace($data, json_decode($model->value, true));
        }
        $this->load([(new \ReflectionClass($this))->getShortName() => $data]);
    }

    public function save()
    {
        if ($this->validate()) {

            $condition = [
                'name' => static::NAME, 
                'type' => Setting::TYPE_JSON
            ];

            $model = Setting::findOne($condition) ?: new Setting($condition);
            $model->value = json_encode($this->attributes);
            $model->save();

            return true;
        }

        return false;
    }
}