<?php
namespace app\filters;

use Yii;
use app\helpers\App;
use yii\base\ActionFilter;

class AccessControl extends \yii\filters\AccessControl
{
    public $adminActions;
    public $publicActions = [''];

    public function init()
    {
        $access =  App::component('access');

        $this->adminActions = $this->adminActions ?: $access->my_actions();
        $this->only = $access->actions();

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