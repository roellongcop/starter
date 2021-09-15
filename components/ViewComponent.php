<?php

namespace app\components;

use Yii;
use app\helpers\App;
use app\models\Theme;
use yii\helpers\Json;
use app\helpers\Url;

class ViewComponent extends \yii\web\View
{
    public $bundles;

    public function init()
    {
        $this->setTheTheme();

        $options = Json::htmlEncode([
            'appName' => App::appName(),
            'baseUrl' => Url::base(true) . '/',
            'language' => App::appLanguage(),
            'api' => Url::base(true) . '/api/v1/',
            'csrfToken' => App::request('csrfToken'),
            'csrfParam' => App::request('csrfParam'),
            'params' => App::params()
        ]);

        $registerJs = <<< SCRIPT
            var app = {$options};
            console.log(app)
        SCRIPT;

        $this->registerJs($registerJs, \yii\web\View::POS_HEAD, 'app');

        parent::init();
    }

    public function setTheTheme()
    {
        $theme = '';

        if (App::isLogin()) {

            if (($slug = App::get('preview-theme')) != NULL) {
                $theme = Theme::findOne(['slug' => $slug]);
            }
            else {
                $theme = App::identity('currentTheme');
            }
        }

        $theme = $theme ?: Theme::findOne(App::generalSetting('theme'));
        $this->bundles = $theme->bundles;

        $this->theme = [
            'basePath' => $theme->base_path,
            'baseUrl' => $theme->base_url,
            'pathMap' => $theme->path_map,
        ];
    }


	public function registerWidgetJs($widgetFunction, $js, $position = parent::POS_READY, $key = null)
    {
        $js = "var {$widgetFunction} = function() {
            var load = function() {
                {$js}
            }

            return {
                init: function() {
                    load();
                }
            }
        }(); {$widgetFunction}.init();";

        parent::registerjs($js, parent::POS_READY, $key);
    }
}