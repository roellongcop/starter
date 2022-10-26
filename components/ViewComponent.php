<?php

namespace app\components;

use Yii;
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

        $loadingIcon = App::baseUrl('default/loader-blocks.gif');

        $this->registerJs($js, \yii\web\View::POS_HEAD, 'app');
        $this->registerCss(<<< CSS
            .mw-500 {width: -webkit-fill-available !important; max-width: 500px !important;}
            .mw-400 {width: -webkit-fill-available !important; max-width: 400px !important;}
            .mw-200 {width: -webkit-fill-available !important; max-width: 200px !important;}
            .mw-150 {width: -webkit-fill-available !important; max-width: 150px !important;}
            .mw-100 {width: -webkit-fill-available !important; max-width: 100px !important;}
            .mw-120 {width: -webkit-fill-available !important; max-width: 120px !important;}
            
            /*.page-loading * {*/
                /*opacity: 0;*/
                /*pointer-events: none;*/
                /*-webkit-touch-callout: none;*/ /* iOS Safari */
                /*-webkit-user-select: none;*/ /* Safari */
                /*-khtml-user-select: none;*/ /* Konqueror HTML */
                /*-moz-user-select: none;*/ /* Old versions of Firefox */
                /*-ms-user-select: none;*/ /* Internet Explorer/Edge */
                /*user-select: none;*/ /* Non-prefixed version, currently
                    supported by Chrome, Edge, Opera and Firefox */
            /*}*/
            /*.page-loading::before {
                content: "Loading...";
            }*/
            /*.page-loading {
                background: white url('{$loadingIcon}') no-repeat center center / 10rem;
            }*/
        CSS);
    }

	public function registerWidgetJs($widgetFunction, $js, $position = parent::POS_READY, $key = null)
    {
        $js = <<< JS
            let {$widgetFunction} = function() {
                let load = function() {
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

    public function registerWidgetCssFile ($files)
    {
        $files = is_array($files) ? $files: [$files];

        foreach ($files as $css) {
            $this->registerCssFile(App::publishedUrl("/widget/css/{$css}.css", Yii::getAlias('@app/assets')), [
                'depends' => [
                    'yii\web\YiiAsset',
                    'yii\bootstrap\BootstrapAsset',
                ]
            ]);
        }
    }

    public function registerWidgetJsFile ($files)
    {
        $files = is_array($files) ? $files: [$files];
        foreach ($files as $js) {
            $this->registerJsFile(App::publishedUrl("/widget/js/{$js}.js", Yii::getAlias('@app/assets')), [
                'depends' => [
                    'yii\web\YiiAsset',
                    'yii\bootstrap\BootstrapAsset',
                ]
            ]);
        }
    }
}