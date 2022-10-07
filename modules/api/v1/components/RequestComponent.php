<?php

namespace app\modules\api\v1\components;

class RequestComponent extends \app\components\RequestComponent
{
	public $parser = [
        'application/json' => '\yii\web\JsonParser'
    ];
}