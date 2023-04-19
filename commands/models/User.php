<?php

namespace app\commands\models;

class User extends \app\models\User
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