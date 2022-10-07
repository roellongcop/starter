<?php

namespace app\modules\api\v1\controllers;

/**
 * Default controller for the `api` module
 */
class DefaultController extends RestController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return ['app\modules\api\v1\controllers'];
    }
}