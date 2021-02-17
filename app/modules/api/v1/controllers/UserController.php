<?php

namespace app\modules\api\v1\controllers;

use app\helpers\App;
use app\modules\api\v1\models\User;
use app\modules\api\v1\models\sub\UserAvailable;
use yii\data\ActiveDataProvider;
use yii\web\Response;

/**
 * Default controller for the `api` module
 */
class UserController extends ActiveController
{
    public $modelClass = '\app\modules\api\v1\models\User';


    public function actionAvailableUsers()
    {
        $this->serializer = [
            'class' => 'yii\rest\Serializer',
            'collectionEnvelope' => 'users',
        ];

        return new ActiveDataProvider([
            'query' => UserAvailable::find(),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
    } 
}
