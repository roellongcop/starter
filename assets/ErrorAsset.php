<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ErrorAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@app/assets';

    public $css = [
        'css/font-Poppins.css',
        'css/starter.css'
    ];
    public $js = [
        'js/starter.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
