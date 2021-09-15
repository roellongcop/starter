<?php

namespace app\components;

use Yii;

class UserComponent extends \yii\web\User
{
    public $identityClass = 'app\models\User';
}