<?php

namespace app\controllers;

use Yii;
use app\helpers\App;
use app\models\Theme;
use app\models\search\IpSearch;
use app\models\search\SettingSearch;
use yii\base\Theme as BaseTheme;
use yii\web\ForbiddenHttpException;

/**
 * RoleController implements the CRUD actions for Role model.
 */
abstract class MainController extends \yii\web\Controller
{
    public function behaviors()
    {
        return App::component('access')
            ->behaviors();
    } 

    public function beforeAction($action)
    {
        Yii::$app->access->createNavigation();
    	if (parent::beforeAction($action)) {

            if (! App::isController('site')) {
                if (App::isLogin() && App::identity('is_blocked')) {
                    throw new ForbiddenHttpException('User is Blocked !');
                }

                if (in_array(App::ip(), IpSearch::blocked())) {
                    throw new ForbiddenHttpException('IP is Blocked !');
                }
            }

            if (App::isLogin()) {
                $theme = App::identity('currentTheme');
            }
            else {
                $theme = Theme::findOne(SettingSearch::default('theme'));
            }
            if ($theme->bundles) {
                Yii::$app->assetManager->bundles = $theme->bundles;
            }
            
    		$themeModel = new BaseTheme();
			$themeModel->basePath = $theme->base_path;
			$themeModel->baseUrl = $theme->base_url;
			$themeModel->pathMap = $theme->path_map;

			Yii::$app->view->theme = $themeModel;
            Yii::$app->session->timeout = SettingSearch::default('auto_logout_timer');
    		return true;
    	}
    }
}
