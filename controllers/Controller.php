<?php

namespace app\controllers;

use Yii;
use app\filters\AccessControl;
use app\filters\IpFilter;
use app\filters\UserFilter;
use app\filters\VerbFilter;
use app\filters\VisitorFilter;
use app\filters\ThemeFilter;
use app\helpers\App;
use app\models\File;
use app\models\ModelFile;

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
            'ThemeFilter' => ['class' => ThemeFilter::className()],
            'VisitorFilter' => ['class' => VisitorFilter::className()],
            'UserFilter' => ['class' => UserFilter::className()],
            'IpFilter' => ['class' => IpFilter::className()],
            'AccessControl' => ['class' => AccessControl::className()],
            'VerbFilter' => ['class' => VerbFilter::className()],
        ];
    } 
}