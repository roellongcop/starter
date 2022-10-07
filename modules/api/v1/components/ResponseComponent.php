<?php

namespace app\modules\api\v1\components;

use yii\web\Response;

class ResponseComponent extends \yii\web\Response
{
	public $formatters = [
		Response::FORMAT_JSON => [
            'class' => 'yii\web\JsonResponseFormatter',
            'prettyPrint' => YII_DEBUG, // use "pretty" output in debug mode
            'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
        ],
	];

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['ApiBehavior'] = 'app\modules\api\v1\behaviors\ApiBehavior';

        return $behaviors;
    }
}