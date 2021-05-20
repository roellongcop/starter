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
class KeenDemo1ErrorAsset extends AssetBundle
{
    public $sourcePath = '@app/themes/keen/sub/demo1/main/assets/assets';
    public $css = [
        'https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700',
        'plugins/global/plugins.bundle.css',
        'plugins/custom/prismjs/prismjs.bundle.css',
        'css/style.bundle.css',
        'css/themes/layout/header/base/light.css',
        'css/themes/layout/header/menu/light.css',
        'css/themes/layout/brand/dark.css',
        'css/themes/layout/aside/dark.css',
        'css/demo1.css'
    ];
    public $js = [
        'plugins/custom/prismjs/prismjs.bundle.js',
        'js/scripts.bundle.js',
        'js/demo1.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}