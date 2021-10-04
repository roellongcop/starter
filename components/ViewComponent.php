<?php

namespace app\components;

use Yii;
use app\helpers\App;
use app\models\Theme;
use yii\helpers\Json;
use app\helpers\Url;

class ViewComponent extends \yii\web\View
{
    public function init()
    {
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