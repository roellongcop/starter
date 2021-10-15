<?php

namespace app\controllers;

use Yii;

/**
 * RoleController implements the CRUD actions for Role model.
 */
abstract class Controller extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        return true;
    }

    public function behaviors()
    {
        return [
            'ThemeFilter' => [
                'class' => 'app\filters\ThemeFilter'
            ],
            'VisitorFilter' => [
                'class' => 'app\filters\VisitorFilter'
            ],
            'UserFilter' => [
                'class' => 'app\filters\UserFilter'
            ],
            'IpFilter' => [
                'class' => 'app\filters\IpFilter'
            ],
            'AccessControl' => [
                'class' => 'app\filters\AccessControl'
            ],
            'VerbFilter' => [
                'class' => 'app\filters\VerbFilter'
            ],
        ];
    } 
}