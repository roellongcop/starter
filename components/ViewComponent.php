<?php

namespace app\components;

use app\helpers\App;
use yii\helpers\Json;
use app\helpers\Url;

class ViewComponent extends \yii\web\View
{
    public function init()
    {
        parent::init();

        $options = Json::htmlEncode([
            'appName' => App::appName(),
            'baseUrl' => Url::base(true) . '/',
            'language' => App::appLanguage(),
            'api' => Url::base(true) . '/api/v1/',
            'csrfToken' => App::request('csrfToken'),
            'csrfParam' => App::request('csrfParam'),
            'params' => App::params()
        ]);

        $js = <<< JS
            var app = {$options};
            console.log(app)
        JS;

        $this->registerJs($js, \yii\web\View::POS_HEAD, 'app');
        $this->registerCss(<<< CSS
            .page-loading * {
                opacity: 0;
                pointer-events: none;
                -webkit-touch-callout: none; /* iOS Safari */
                -webkit-user-select: none; /* Safari */
                -khtml-user-select: none; /* Konqueror HTML */
                -moz-user-select: none; /* Old versions of Firefox */
                -ms-user-select: none; /* Internet Explorer/Edge */
                user-select: none; /* Non-prefixed version, currently
                    supported by Chrome, Edge, Opera and Firefox */
            }
            /*.page-loading::before {
                content: "Loading...";
            }*/
            .page-loading {
                background: white url('/default/loader-blocks.gif') no-repeat center center / 10rem;
            }
        CSS);
    }

	public function registerWidgetJs($widgetFunction, $js, $position = parent::POS_READY, $key = null)
    {
        $js = <<< JS
            var {$widgetFunction} = function() {
                var load = function() {
                    {$js}
                }
                return {
                    init: function() {
                        load();
                    }
                }
            }(); {$widgetFunction}.init();
        JS;

        parent::registerjs($js, $position, $key);
    }
}