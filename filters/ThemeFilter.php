<?php

namespace app\filters;

use Yii;
use app\helpers\App;
use app\models\Theme;
use yii\base\ActionFilter;
use yii\base\Theme as BaseTheme;

class ThemeFilter extends ActionFilter
{
    public $theme;

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        $theme = '';
        if (App::isLogin()) {
            if (($slug = App::get('preview-theme')) != null) {
                $theme = Theme::findOne(['slug' => $slug]);
            }
            else {
                $theme = App::identity('currentTheme');
            }
        }
        $theme = $theme ?: Theme::findOne(App::setting('system')->theme);
        $theme = $this->theme ?: $theme;

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