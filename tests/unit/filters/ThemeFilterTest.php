<?php

namespace tests\unit\models;

use yii\base\Theme as BaseTheme;
use app\filters\ThemeFilter;
use app\helpers\App;
use app\models\Theme;

class ThemeFilterTest extends \Codeception\Test\Unit
{
    public function testSetThemeLogin()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', ['username' => 'developer']));
        $model = new ThemeFilter();
        expect_that($model->beforeAction(1));

        $theme = App::identity('currentTheme');

        $this->setTheme($theme);
    }

    public function testSetThemeGuest()
    {
        $model = new ThemeFilter();
        expect_that($model->beforeAction(1));

        $theme = Theme::findOne(App::generalSetting('theme'));

        $this->setTheme($theme);
    }

    public function setTheme($theme)
    {
        if ($theme->bundles) {
            expect(App::assetManager('bundles'))->equals($theme->bundles);
        }

        $themeModel = new BaseTheme();
        $themeModel->basePath = $theme->base_path;
        $themeModel->baseUrl = $theme->base_url;
        $themeModel->pathMap = $theme->path_map;

        App::view()->theme = $themeModel;
        expect(App::view('theme'))->equals($themeModel);
    }
}