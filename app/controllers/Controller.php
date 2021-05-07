<?php

namespace app\controllers;

use Yii;
use app\models\ModelFile;
use app\filters\AccessControl;
use app\filters\IpFilter;
use app\filters\ModelFileFilter;
use app\filters\ThemeFilter;
use app\filters\UserFilter;
use app\filters\VerbFilter;
use app\helpers\App;
use yii\web\ForbiddenHttpException;

/**
 * RoleController implements the CRUD actions for Role model.
 */
abstract class Controller extends \yii\web\Controller
{
    public $model_file_id_name = '_model_file_id';

    public function behaviors()
    {
        return [
            'UserFilter' => [
                'class' => UserFilter::className(),
            ],
            'IpFilter' => [
                'class' => IpFilter::className(),
            ],
            'AccessControl' => [
                'class' => AccessControl::className()
            ],
            'VerbFilter' => [
                'class' => VerbFilter::className()
            ],
            'ThemeFilter' => [
                'class' => ThemeFilter::className()
            ],
            'SettingFilter' => [
                'class' => SettingFilter::className()
            ],
        ];
    } 


    public function checkModelFile($model)
    {
        if (($post = App::post()) != null) {
            if (!empty($post[$this->model_file_id_name])) {
                $modelFile = ModelFile::findOne($post[$this->model_file_id_name]);

                if ($modelFile) {
                    $modelFile->model_id = $model->id;
                    $modelFile->save();

                    return $modelFile;
                }
            }
        }
    }
}
