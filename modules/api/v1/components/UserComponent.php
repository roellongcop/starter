<?php

namespace app\modules\api\v1\components;

class UserComponent extends \yii\web\User
{
    public $identityClass = 'app\modules\api\v1\models\User';
}