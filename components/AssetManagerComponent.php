<?php

namespace app\components;

class AssetManagerComponent extends \yii\web\AssetManager
{
    public $linkAssets = true;
    public $appendTimestamp = true;
}