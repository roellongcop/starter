<?php

namespace app\themes\keen\sub\demo2\fixed\assets;

class AppAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@app/themes/keen/sub/demo2/fixed/assets/assets';
    public $css = [
        // 'https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700',
        'plugins/custom/prismjs/prismjs.bundle.css',
        'css/style.bundle.css',
        // 'css/demo2.css',
    ];
    public $js = [
        'plugins/custom/prismjs/prismjs.bundle.js',
        'js/scripts.bundle.js',
        // 'js/demo2.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}