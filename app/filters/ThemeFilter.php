<?php
namespace app\filters;

use Yii;
use app\helpers\App;
use app\models\Theme;
use app\models\search\SettingSearch;
use yii\base\ActionFilter;
use yii\base\Theme as BaseTheme;

class ThemeFilter extends ActionFilter
{
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        if (App::isLogin()) {
            $theme = App::identity('currentTheme');
        }
        else {
            $theme = Theme::findOne(SettingSearch::default('theme'));
        }

        if ($theme) {
            if ($theme->bundles) {
                App::assetManager()->bundles = $theme->bundles;
            }
            
            $themeModel = new BaseTheme();
            $themeModel->basePath = $theme->base_path;
            $themeModel->baseUrl = $theme->base_url;
            $themeModel->pathMap = $theme->path_map;

            App::view()->theme = $themeModel;
        }
        return true;
    }
}