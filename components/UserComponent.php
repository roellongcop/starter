<?php

namespace app\components;

use Yii;

class UserComponent extends \yii\web\User
{
    public $identityClass = 'app\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['VisitLogBehavior'] = [
            'class' => 'app\behaviors\VisitLogBehavior'
        ];

        return $behaviors;
    }
}