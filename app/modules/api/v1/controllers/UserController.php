<?php

namespace app\modules\api\v1\controllers;

use app\helpers\App;
use app\modules\api\v1\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Response;

/**
 * Default controller for the `api` module
 */
class UserController extends ActiveController
{
    public $modelClass = '\app\modules\api\v1\models\User';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'users',
    ];

    public function actionAvailableUsers()
    {
        // $this->serializer['collectionEnvelope'] = 'availableUsers';
        return new ActiveDataProvider([
            'query' => User::find()
                ->available(),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
    } 
}
