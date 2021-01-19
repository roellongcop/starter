<?php

namespace app\controllers;

use Yii;
use app\filters\AccessControl;
use app\filters\ActionTimeFilter;
use app\filters\IpFilter;
use app\filters\UserFilter;
use app\filters\VerbFilter;
use app\helpers\App;
use app\models\Theme;
use app\models\search\IpSearch;
use app\models\search\SettingSearch;
use yii\base\Theme as BaseTheme;
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
        ];
    } 

    public function beforeAction($action)
    {
        if (App::isLogin()) {
            $theme = App::identity('currentTheme');
        }
        else {
            $theme = Theme::findOne(SettingSearch::default('theme'));
        }

        if ($theme) {
            if ($theme->bundles) {
                Yii::$app->assetManager->bundles = $theme->bundles;
            }
            
    		$themeModel = new BaseTheme();
    		$themeModel->basePath = $theme->base_path;
    		$themeModel->baseUrl = $theme->base_url;
    		$themeModel->pathMap = $theme->path_map;

    		Yii::$app->view->theme = $themeModel;
            Yii::$app->session->timeout = SettingSearch::default('auto_logout_timer');
        }

        return parent::beforeAction($action);
    }
}
