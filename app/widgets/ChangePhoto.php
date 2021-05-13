<?php
namespace app\widgets;

use Yii;
use app\helpers\App;
use yii\helpers\Url;
 
class ChangePhoto extends \yii\base\Widget
{
    public $modelTitle = 'Change Photo';
    public $buttonTitle = 'Change Photo';
    public $files;
    public $changePhotoUrl;
    public $uploadUrl;
    public $model;
    public $modelName;
    public $model_id;
    public $ajaxSuccess = 'function(s) {console.log(s)}';
    public $ajaxError = 'function(e) {alert(e.responseText)}';
    public $dropzoneComplete;
    public $fileInput;

    public $myImageFilesUrl = ['file/my-image-files'];

    public function init() 
    {
        // your logic here
        parent::init();

        $this->changePhotoUrl = $this->changePhotoUrl ?: Url::to(['file/change-photo']);
        $this->uploadUrl = $this->uploadUrl ?: Url::to(['file/upload']);

        $this->modelName = App::className($this->model);
        $this->model_id = $this->model->id;
        $this->files = $this->files ?: App::identity('myImageFiles');
    }


    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('change_photo', [
            'modelTitle' => $this->modelTitle,
            'buttonTitle' => $this->buttonTitle,
            'id' => $this->id,
            'files' => $this->files,
            'changePhotoUrl' => $this->changePhotoUrl,
            'uploadUrl' => $this->uploadUrl,
            'modelName' => $this->modelName,
            'model_id' => $this->model_id,
            'ajaxSuccess' => $this->ajaxSuccess,
            'ajaxError' => $this->ajaxError,
            'model' => $this->model,
            'dropzoneComplete' => $this->dropzoneComplete,
            'fileInput' => $this->fileInput,
            'myImageFilesUrl' => Url::to($this->myImageFilesUrl),
        ]);
    }
}
