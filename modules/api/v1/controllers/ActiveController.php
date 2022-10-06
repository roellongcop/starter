<?php

namespace app\modules\api\v1\controllers;

use yii\web\Response;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

/**
 * Default controller for the `api` module
 */
abstract class ActiveController extends \yii\rest\ActiveController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats'] = [
            'application/json' => Response::FORMAT_JSON,
            // 'application/xml' => Response::FORMAT_XML,
            // 'text/html' => Response::FORMAT_HTML
        ];

        // Supporting Authenticator
        // sample request
        // http://[host]/api/v1/user/available-users?access-token=access-fGurkHEAh4OSAT6BuC66_1621994603

        
        // $behaviors['authenticator'] = [
        //     'class' => CompositeAuth::class,
        //     'authMethods' => [
        //         HttpBasicAuth::class,
        //         HttpBearerAuth::class,
        //         QueryParamAuth::class,
        //     ],
        // ];
        return $behaviors;
    }
}