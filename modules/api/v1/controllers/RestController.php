<?php

namespace app\modules\api\v1\controllers;

use yii\web\Response;
use app\helpers\App;

/**
 * Default controller for the `api` module
 */
abstract class RestController extends \yii\rest\Controller
{

    public function beforeAction($action)
    {
        App::component('response')->formatters = [
            Response::FORMAT_JSON => [
                'class' => 'yii\web\JsonResponseFormatter',
                'prettyPrint' => YII_DEBUG, // use "pretty" output in debug mode
                'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
            ],
        ];

        return parent::beforeAction($action);
    }
    
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats'] = [
            'application/json' => Response::FORMAT_JSON,
            // 'application/xml' => Response::FORMAT_XML,
            // 'text/html' => Response::FORMAT_HTML
        ];
        return $behaviors;
    }
}