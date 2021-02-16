<?php

namespace app\modules\api\v1\controllers;

use app\modules\api\v1\models\User;
use yii\web\Response;

/**
 * Default controller for the `api` module
 */
class UserController extends ActiveController
{
    public $modelClass = '\app\modules\api\v1\models\User';

    public function actionAvailableUsers()
    {
        $models = User::find()
            ->select(['email'])
            ->where([
                'record_status' => 1,
                'status' => 10,
                'is_blocked' => 0
            ])
            ->all();

        return $models;
    } 
}
