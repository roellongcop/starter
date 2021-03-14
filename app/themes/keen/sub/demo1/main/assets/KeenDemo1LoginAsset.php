<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\themes\keen\sub\demo1\main\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class KeenDemo1LoginAsset extends AssetBundle
{
    public $sourcePath = '@app/themes/keen/sub/demo1/main/assets/assets';
    public $css = [
        'https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700',
        'css/pages/login/login-1.css',
        'plugins/custom/prismjs/prismjs.bundle.css',
        'css/style.bundle.css',
        'css/demo1.css'
    ];
    public $js = [
        'plugins/custom/prismjs/prismjs.bundle.js',
        'js/scripts.bundle.js',
        'js/pages/custom/login/login.js',
        'js/demo1.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}