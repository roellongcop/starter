<?php

namespace app\widgets;

use Yii;
use app\helpers\App;
use app\helpers\Url;
 
class ImageGallery extends AppWidget
{
    public $file_id;
    public $modalTitle = 'Image Gallery';
    public $buttonTitle = 'Image Gallery';
    public $uploadUrl = ['file/upload'];
    public $ajaxSuccess;
    public $model;
    public $modelName;
    public $ajaxError = 'function(e) {alert(e.responseText)}';
    public $fileInput;
    public $myImageFilesUrl = ['file/my-image-files'];

    public $inputName;
    public $parameters;
    public $defaultPhoto;

    public $uploadFileName;


    public function init() 
    {
        // your logic here
        parent::init();

        $this->uploadUrl = Url::to($this->uploadUrl);
        if ($this->model) {
            $this->modelName = App::getModelName($this->model);
        }

        $this->parameters[App::request('csrfParam')] = App::request('csrfToken');

        $this->parameters['UploadForm[modelName]'] = $this->modelName ?: App::className($this->model);

        $this->defaultPhoto = App::setting('image')->image_holder;
        $this->uploadFileName = $this->uploadFileName ?: $this->parameters['UploadForm[modelName]'];
    }


    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('image-gallery', [
            'inputName' => $this->inputName,
            'model' => $this->model,
            'modelName' => $this->modelName,
            'modalTitle' => $this->modalTitle,
            'buttonTitle' => $this->buttonTitle,
            'id' => $this->id,
            'uploadUrl' => $this->uploadUrl,
            'ajaxSuccess' => $this->ajaxSuccess,
            'ajaxError' => $this->ajaxError,
            'fileInput' => $this->fileInput,
            'myImageFilesUrl' => Url::to($this->myImageFilesUrl),
            'file_id' => $this->file_id,
            'defaultPhoto' => $this->defaultPhoto,
            'uploadFileName' => $this->uploadFileName,
            'parameters' => json_encode($this->parameters),
        ]);
    }
}
