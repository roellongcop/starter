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
    public $file_id_name = '_file_id';

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

    public function checkFileUpload($model, $file_ids = [])
    {
        $arr = [];
        $file_ids = $file_ids ?: App::post($this->file_id_name);
        
        if ($file_ids) {
            $file_ids = is_array($file_ids)? $file_ids: [$file_ids];
            foreach ($file_ids as $key => $file_id) {
                $file = File::findOne($file_id);

                if ($file) {
                    $modelFile = new ModelFile([
                        'file_id' => $file->id,
                        'model_id' => $model->id,
                        'record_status' => 1,
                        'extension' => $file->extension,
                        'model_name' => App::getModelName($model),
                    ]);

                    if ($modelFile->save()) {
                        array_push($arr, $modelFile);
                    }
                }
            }
        }
        return $arr;
    }
}