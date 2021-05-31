<?php

namespace app\commands\models;

use Yii;

class Role extends \app\models\Role
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['TimestampBehavior']);
        return $behaviors;
    }
}
