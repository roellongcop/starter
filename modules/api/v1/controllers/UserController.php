<?php

namespace app\modules\api\v1\controllers;

use app\modules\api\v1\models\User;
use yii\data\ActiveDataProvider;

/**
 * Default controller for the `api` module
 */
class UserController extends ActiveController
{
    public $modelClass = '\app\modules\api\v1\models\User';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'user',
    ];

    public function actionAvailableUsers()
    {
        // $this->serializer['collectionEnvelope'] = 'availableUsers';
        return new ActiveDataProvider([
            'query' => User::find()
                ->alias('u')
                ->available()
                ->joinWith('role r')
                ->active('r'),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
    } 
}
