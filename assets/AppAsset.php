<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{  
    public $sourcePath = '@app/assets';

    public $css = [
        // 'https://pro.fontawesome.com/releases/v5.10.0/css/all.css',
        'jsoneditor/jsoneditor.css', 
        'css/starter.css'
    ];
    public $js = [
        'js/jquery.nestable.js',
        'jsoneditor/jsoneditor.js',
        // 'sortable/Sortable.js',
        'js/starter.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
