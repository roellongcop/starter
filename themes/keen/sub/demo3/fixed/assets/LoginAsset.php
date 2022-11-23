<?php

namespace app\themes\keen\sub\demo3\fixed\assets;

class LoginAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@app/themes/keen/sub/demo3/fixed/assets/assets';
    public $css = [
        // 'https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700',
        'plugins/custom/prismjs/prismjs.bundle.css',
        'css/style.bundle.css',
        'css/pages/login/login-1.css',
        // 'css/demo3.css'
    ];
    public $js = [
        'plugins/custom/prismjs/prismjs.bundle.js',
        'js/scripts.bundle.js',
        'js/pages/custom/login/login.js',
        // 'js/demo3.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}