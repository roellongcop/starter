<?php

namespace app\components;

use Yii;
use app\helpers\App;
use app\helpers\Url;

class ViewComponent extends \yii\web\View
{
    public function init()
    {
        parent::init();

        $this->registerJsVar('app', [
            'appName' => App::appName(),
            'baseUrl' => Url::base(true) . '/',
            'language' => App::appLanguage(),
            'api' => Url::base(true) . '/api/v1/',
            'csrfToken' => App::request('csrfToken'),
            'csrfParam' => App::request('csrfParam'),
            // 'params' => App::params(),
        ]);
    }

    public function registerWidgetJs($widgetFunction, $js, $position = parent::POS_READY, $key = null)
    {
        $js = <<<JS
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

    public function registerWidgetCssFile($files, $depends = [])
    {
        $depends = $depends ?: [
            'yii\web\YiiAsset',
            'yii\bootstrap\BootstrapAsset',
        ];
        $files = is_array($files) ? $files : [$files];
        foreach ($files as $css) {
            $this->registerCssFile(App::publishedUrl("/widget/css/{$css}.css", Yii::getAlias('@app/assets')), [
                'depends' => $depends
            ]);
        }
    }

    public function registerWidgetJsFile($files, $depends = [])
    {
        $depends = $depends ?: [
            'yii\web\YiiAsset',
            'yii\bootstrap\BootstrapAsset',
        ];
        $files = is_array($files) ? $files : [$files];
        foreach ($files as $js) {
            $this->registerJsFile(App::publishedUrl("/widget/js/{$js}.js", Yii::getAlias('@app/assets')), [
                'depends' => $depends
            ]);
        }
    }

    public function addJsFile($files, $depends = [])
    {
        $depends = $depends ?: [
            'yii\web\YiiAsset',
            'yii\bootstrap\BootstrapAsset',
        ];
        $files = is_array($files) ? $files : [$files];
        foreach ($files as $js) {
            $this->registerJsFile(App::publishedUrl("/{$js}.js", Yii::getAlias('@app/assets')), [
                'depends' => $depends
            ]);
        }
    }

    public function addCssFile($files, $depends = [])
    {
        $depends = $depends ?: [
            'yii\web\YiiAsset',
            'yii\bootstrap\BootstrapAsset',
        ];
        $files = is_array($files) ? $files : [$files];
        foreach ($files as $css) {
            $this->registerCssFile(App::publishedUrl("/{$css}.css", Yii::getAlias('@app/assets')), [
                'depends' => $depends
            ]);
        }
    }
}