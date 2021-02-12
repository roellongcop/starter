<?php

namespace app\controllers;

use Yii;
use app\filters\AccessControl;
use app\filters\IpFilter;
use app\filters\UserFilter;
use app\filters\VerbFilter;
use app\filters\ThemeFilter;

use app\helpers\App;
use yii\helpers\Json;
use yii\helpers\Url;
use app\models\search\IpSearch;
use app\models\search\SettingSearch;
use yii\web\ForbiddenHttpException;

/**
 * RoleController implements the CRUD actions for Role model.
 */
abstract class Controller extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'user' => [
                'class' => UserFilter::className(),
            ],
            'ip' => [
                'class' => IpFilter::className(),
            ],
            'access' => [
                'class' => AccessControl::className()
            ],
            'verbs' => [
                'class' => VerbFilter::className()
            ],
            'theme' => [
                'class' => ThemeFilter::className()
            ],
        ];
    } 

    public function beforeAction($action)
    {
        $options = Json::htmlEncode([
            'appName' => Yii::$app->name,
            'baseUrl' => Url::base(true),
            'language' => Yii::$app->language,
        ]);
        $this->view->registerJs(<<<SCRIPT
            var yiiOptions = {$options};
            console.log(yiiOptions)
        SCRIPT , \yii\web\View::POS_HEAD, 'yiiOptions');
        
        

        Yii::$app->session->timeout = SettingSearch::default('auto_logout_timer');
        return parent::beforeAction($action);
    }
}
