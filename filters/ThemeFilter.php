<?php

namespace app\filters;

use app\helpers\App;
use app\models\Theme;
use yii\base\Theme as BaseTheme;

class ThemeFilter extends \yii\base\ActionFilter
{
    public $theme;

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        $theme = '';
        if (App::isLogin()) {
            $theme = App::ifElse(
                App::get('preview-theme'), 
                fn($slug) => Theme::findOne(['slug' => $slug]), 
                fn($slug) => App::identity('currentTheme')
            );
        }
        $theme = $theme ?: App::setting('theme');
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