<?php

namespace app\modules\api\v1;

use Yii;

/**
 * api module definition class
 */
class Version1Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\api\v1\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here

        Yii::$app->user->enableSession = false;

        Yii::$app->setComponents([
            'request' => [
                'class' => '\app\components\RequestComponent',
                'parsers' => [
                    'application/json' => '\yii\web\JsonParser'
                ]
            ],
            'response' => [
                'class' => '\app\modules\api\v1\components\ResponseComponent',
                'formatters' => [
                    \yii\web\Response::FORMAT_JSON => [
                        'class' => 'yii\web\JsonResponseFormatter',
                        'prettyPrint' => YII_DEBUG, // use "pretty" output in debug mode
                        'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                    ],
                ]
            ],
        ]);
    }
}