<?php

namespace app\components;

use Yii;
use app\helpers\App;

class AssetManagerComponent extends \yii\web\AssetManager
{
    public $appendTimestamp = true;
}