<?php
namespace app\widgets;

use Yii;
use app\helpers\App;
use yii\helpers\Url;
 
class ChooseFromGallery extends \yii\base\Widget
{
    public $modelTitle = 'Choose from Gallery';
    public $buttonTitle = 'Choose from Gallery';
    public $files;
    public $chooseImageUrl;
    public $uploadUrl;
    public $model;
    public $modelName;
    public $ajaxSuccess;
    public $ajaxError = 'function(e) {alert(e.responseText)}';
    public $dropzoneComplete;
    public $dropzoneSuccess;
    public $fileInput;
    public $myImageFilesUrl = ['file/my-image-files'];

    public function init() 
    {
        // your logic here
        parent::init();

        $this->chooseImageUrl = $this->chooseImageUrl ?: Url::to(['file/choose-from-gallery']);
        $this->uploadUrl = $this->uploadUrl ?: Url::to(['file/upload']);
        $this->modelName = App::className($this->model);
        $this->files = $this->files ?: App::identity('myImageFiles');
    }


    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('choose_from_gallery', [
            'modelTitle' => $this->modelTitle,
            'buttonTitle' => $this->buttonTitle,
            'id' => $this->id,
            'files' => $this->files,
            'chooseImageUrl' => $this->chooseImageUrl,
            'uploadUrl' => $this->uploadUrl,

            'modelName' => $this->modelName,
            'ajaxSuccess' => $this->ajaxSuccess,
            'ajaxError' => $this->ajaxError,
            'model' => $this->model,
            'dropzoneComplete' => $this->dropzoneComplete,
            'fileInput' => $this->fileInput,
            'dropzoneSuccess' => $this->dropzoneSuccess,
            'myImageFilesUrl' => Url::to($this->myImageFilesUrl),
        ]);
    }
}
