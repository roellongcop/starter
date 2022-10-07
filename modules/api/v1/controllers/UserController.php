<?php

namespace app\modules\api\v1\controllers;

use app\modules\api\v1\models\sub\AvailableUser;
use yii\data\ActiveDataProvider;

/**
 * Default controller for the `api` module
 */
class UserController extends ActiveController
{
    public $modelClass = 'app\modules\api\v1\models\User';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'user',
    ];

    public function actions()
    {
        $actions = parent::actions();

        /*$actions['index']['dataFilter'] = [
            'class' => \yii\data\ActiveDataFilter::class,
            // 'attributeMap' => ['username' => 'username'],
            'searchModel' => \app\models\search\UserSearch::class
        ];*/

        $actions['index']['prepareSearchQuery'] = function($query, $requestParams) {
            $query->andFilterWhere(['or', 
                ['like', 'username', $requestParams['keywords'] ?? ''],  
                ['like', 'email', $requestParams['keywords'] ?? ''],  
            ]);

            return $query;
        };

        return $actions;
    }

    public function actionAvailableUsers()
    {
        // $this->serializer['collectionEnvelope'] = 'availableUsers';
        return [
            'users' => new ActiveDataProvider([
                'query' => AvailableUser::find()
                    ->alias('u')
                    ->available()
                    ->joinWith('role r')
                    ->active('r'),
                'pagination' => [
                    'pageSize' => 5,
                ],
            ]),
            'post' => \app\helpers\App::post()
        ];
    } 
}