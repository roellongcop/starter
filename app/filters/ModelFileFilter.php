<?php
namespace app\filters;

use Yii;
use app\helpers\App;
use app\models\ModelFile;
use yii\base\ActionFilter;

class ModelFileFilter extends ActionFilter
{
    public $model_file_id_name = 'model_file_id';

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