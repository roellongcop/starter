<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\themes\keen\sub\demo3\fixed\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class KeenDemo3FixedErrorAsset extends AssetBundle
{
    public $sourcePath = '@app/themes/keen/sub/demo3/fixed/assets/assets';
    public $css = [
        'https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700',
        'plugins/global/plugins.bundle.css',
        'plugins/custom/prismjs/prismjs.bundle.css',
        'css/style.bundle.css',
        'css/themes/layout/header/base/light.css',
        'css/themes/layout/header/menu/light.css',
        'css/themes/layout/brand/dark.css',
        'css/themes/layout/aside/dark.css',
        'css/demo3.css'
    ];
    public $js = [
        'plugins/custom/prismjs/prismjs.bundle.js',
        'js/scripts.bundle.js',
        'js/demo3.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}