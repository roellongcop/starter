<?php

namespace app\modules\api\v1\components;

class RequestComponent extends \yii\web\Request
{
    public $cookieValidationKey = 'kACKH_pi2sZVSJRHwBQl6T-9zvnuM30L';
    public $enableCsrfValidation = false;

    public $parser = [
        'application/json' => 'yii\web\JsonParser'
    ];
}