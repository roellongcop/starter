<?php

namespace app\filters;

use app\helpers\App;

class AccessControl extends \yii\filters\AccessControl
{
    public $adminActions;
    public $publicActions = [''];

    public function init()
    {
        $access =  App::component('access');

        $adminActions = $this->adminActions ?: $access->my_actions();
        $adminActions = array_merge($adminActions, $this->publicActions);
        
        $this->adminActions = array_unique($adminActions);
        $this->only = $this->only ?: $access->actions();

        $this->rules = [
            [
                'actions' => $this->adminActions,
                'allow' => true,
                'roles' => ['@'],
            ],
            [
                'actions' => $this->publicActions,
                'allow' => true,
                'roles' => ['?'],
            ],
        ];
        parent::init();
    }
}