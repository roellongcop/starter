<?php

namespace app\themes\keen\sub\demo1\main\assets;

class AppAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@app/themes/keen/sub/demo1/main/assets/assets';
    public $css = [
        // 'https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700',
        // 'plugins/custom/cropper/cropper.bundle.css',
        'plugins/custom/prismjs/prismjs.bundle.css',
        'css/style.bundle.css',
        'css/themes/layout/header/base/light.css',
        'css/themes/layout/header/menu/light.css',
        'css/themes/layout/brand/dark.css',
        'css/themes/layout/aside/dark.css',
        // 'css/demo1.css'
    ];
    public $js = [
        // 'plugins/custom/cropper/cropper.bundle.js',
        'plugins/custom/prismjs/prismjs.bundle.js',
        'js/scripts.bundle.js',
        // 'js/demo1.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}