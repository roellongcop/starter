<?php

namespace app\modules\api\controllers;

/**
 * Default controller for the `api` module
 */
class DefaultController extends \yii\web\Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return 'app\modules\api\controllers';
    }
}