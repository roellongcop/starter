<?php

namespace app\commands\models;

use Yii;

class Ip extends \app\models\Ip
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['TimestampBehavior']);
        return $behaviors;
    }
}
