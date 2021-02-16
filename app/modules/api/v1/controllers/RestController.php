<?php

namespace app\modules\api\v1\controllers;

use yii\web\Response;

/**
 * Default controller for the `api` module
 */
abstract class RestController extends \yii\rest\Controller
{

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
