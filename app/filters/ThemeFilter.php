<?php
namespace app\filters;

use Yii;
use app\helpers\App;
use yii\base\ActionFilter;
use app\models\Theme;
use yii\base\Theme as BaseTheme;

class ThemeFilter extends ActionFilter
{
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
        }
        return parent::beforeAction($action);
    }
}