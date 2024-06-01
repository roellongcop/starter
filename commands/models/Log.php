<?php

namespace app\commands\models;

class Log extends \app\models\Log
{
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [['created_at', 'updated_at'], 'safe'];
        return $rules;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['TimestampBehavior']);
        return $behaviors;
    }
}