<?php
namespace app\widgets;

use Yii;
use app\helpers\App;
use yii\helpers\Url;
 
class AppFiles extends \yii\base\Widget
{
    public $model;
    public $imageOnly = false;
    public $files;
    public $removeImageUrl;
    public $fileDisplay = 'file/display';
    public $fileDownload = 'file/download';
    public $modelName;

    public function init() 
    {
        // your logic here
        parent::init();

        $this->removeImageUrl = $this->removeImageUrl ?: ['model-file/delete'];

        if ($this->imageOnly) {
            $this->files = $this->model->imageFiles ?? '';
        }
        else {
            $this->files = $this->model->files ?? '';
        }

        $this->modelName = $this->modelName ?: App::getModelName($this->model);
    }


    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('app_files', [
            'files' => $this->files,
            'removeImageUrl' => $this->removeImageUrl,
            'removeImagePath' => Url::to($this->removeImageUrl),
            'fileDisplay' => $this->fileDisplay,
            'fileDownload' => $this->fileDownload,
            'modelName' => $this->modelName,
            'model' => $this->model,
        ]);
    }
}
