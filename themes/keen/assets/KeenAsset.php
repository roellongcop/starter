<?php

namespace app\themes\keen\assets;

class KeenAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@app/themes/keen/assets/assets';
    public $css = [
        'css/keen.css'
    ];
    public $js = [
        'js/keen.js'
    ];
    public $depends = [
        'app\assets\AppAsset',
    ];
}
