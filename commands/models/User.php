<?php

namespace app\commands\models;

use Yii;

class User extends \app\models\User
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['TimestampBehavior']);
        return $behaviors;
    }
}
