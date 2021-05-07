<?php

namespace app\controllers;

use Yii;
use app\helpers\App;
use app\models\ModelFile;

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
                'class' => \app\filters\UserFilter::className(),
            ],
            'IpFilter' => [
                'class' => \app\filters\IpFilter::className(),
            ],
            'AccessControl' => [
                'class' => \app\filters\AccessControl::className()
            ],
            'VerbFilter' => [
                'class' => \app\filters\VerbFilter::className()
            ],
            'ThemeFilter' => [
                'class' => \app\filters\ThemeFilter::className()
            ],
            'SettingFilter' => [
                'class' => \app\filters\SettingFilter::className()
            ],
        ];
    } 


    public function checkModelFile($model)
    {
        if (($model_file_id = App::post($this->model_file_id_name)) != null) {

            if (is_array($model_file_id)) {
                $modelFiles = [];
                foreach ($model_file_id as $key => $id) {
                    $modelFile = ModelFile::findOne($id);

                    if ($modelFile) {
                        $modelFile->model_id = $model->id;
                        $modelFile->save();
                        $modelFiles[] = $modelFile;
                    }
                }
                return $modelFiles;
            }
            else {
                $modelFile = ModelFile::findOne($model_file_id);

                if ($modelFile) {
                    $modelFile->model_id = $model->id;
                    $modelFile->save();

                    return $modelFile;
                }
            }
        }
    }
}
