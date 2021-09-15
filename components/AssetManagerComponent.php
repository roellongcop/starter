<?php

namespace app\components;

use Yii;
use app\helpers\App;

class AssetManagerComponent extends \yii\web\AssetManager
{
    public $appendTimestamp = true;

    public function init()
    {
        if (($bundles = App::view('bundles')) != NULL) {
            $this->bundles = $bundles;
        }
        parent::init();
    }
}