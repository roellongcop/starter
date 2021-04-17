<?php

namespace app\controllers;

use Yii;
use app\filters\AccessControl;
use app\filters\IpFilter;
use app\filters\ModelFileFilter;
use app\filters\ThemeFilter;
use app\filters\UserFilter;
use app\filters\VerbFilter;
use app\helpers\App;
use app\models\search\SettingSearch;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;

/**
 * RoleController implements the CRUD actions for Role model.
 */
abstract class Controller extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'UserFilter' => [
                'class' => UserFilter::className(),
            ],
            'IpFilter' => [
                'class' => IpFilter::className(),
            ],
            'AccessControl' => [
                'class' => AccessControl::className()
            ],
            'VerbFilter' => [
                'class' => VerbFilter::className()
            ],
            'ThemeFilter' => [
                'class' => ThemeFilter::className()
            ],
            'ModelFileFilter' => [
                'class' => ModelFileFilter::className()
            ]
        ];
    } 

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        $options = Json::htmlEncode([
            'appName' => App::appName(),
            'baseUrl' => Url::base(true),
            'language' => App::appLanguage(),
            'api' => Url::base(true) . '/api/v1/',
            // 'params' => App::params()
        ]);

        $this->view->registerJs("
            var app = {$options};
            console.log(app)
        ", \yii\web\View::POS_HEAD, 'app');
        
        App::session()->timeout = SettingSearch::default('auto_logout_timer');
        
        return true;
    }
}
