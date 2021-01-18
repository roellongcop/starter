<?php

namespace app\controllers;

use Yii;
use app\helpers\App;
use app\models\User;

class ApiController extends Controller
{

    public function behaviors()
    {
        return App::component('access')
            ->behaviors(['available-users']);
    } 
  
    public function actionAvailableUsers()
    {
        $models = User::find()
            ->select(['email'])
            ->where([
                'record_status' => 1,
                'status' => 10,
                'is_blocked' => 0
            ])
            ->asArray()
            ->all();

        $this->layout = 'login';

        return $this->render('available_users', [
            'models' => $models
        ]);
    } 

    public function actionIndex()
    {
        return $this->render('index');
    }
}
