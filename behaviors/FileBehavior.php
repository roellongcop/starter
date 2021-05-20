<?php
namespace app\behaviors;

use app\helpers\App;
use app\models\ModelFile;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class FileBehavior extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }


    public function afterDelete($event)
    {
        $model = $this->owner;

        $modelName = App::getModelName($model);

        if ($modelName == 'File') {
            ModelFile::deleteAll(['file_id' => $model->id]);
            if (file_exists($model->rootPath)) {
                unlink($model->rootPath);
            }
        }
    }
}