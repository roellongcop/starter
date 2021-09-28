<?php

namespace app\models\form\setting;

use Yii;
use app\models\Setting;
use yii\helpers\ArrayHelper;

abstract class SettingForm extends \yii\base\Model
{
    public abstract function config();
    
    public function init()
    {
        parent::init();

        $config = $this->config();

        $data = ArrayHelper::map($config['defaults'], 'name', 'default');

        if (($model = Setting::findByName($config['name'])) != NULL) {
            $data = array_replace($data, json_decode($model->value, true));
        }
        
        $this->load([$config['className'] => $data]);
    }

    public function save()
    {
        if ($this->validate()) {
            $config = $this->config();

            $condition = [
                'name' => $config['name'], 
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