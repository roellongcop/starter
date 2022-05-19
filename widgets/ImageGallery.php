<?php

namespace app\widgets;

use app\helpers\App;
use app\helpers\Url;
use app\models\File;
 
class ImageGallery extends BaseWidget
{
    public $modalTitle = 'Image Gallery';
    public $buttonTitle = 'Image Gallery';
    public $buttonOptions = ['class' => 'btn btn-primary btn-sm image-gallery-btn'];
    public $uploadUrl = ['file/upload'];
    public $ajaxSuccess;
    
    public $ajaxError = 'function(e) {alert(e.responseText)}';
    public $myImageFilesUrl = ['file/my-image-files'];

    public $parameters;
    public $defaultPhoto;

    public $uploadFileName;

    public $model;
    public $modelName;
    public $attribute;
    public $extensions;

    public $finalCropWidth = 500;
    public $finalCropHeight = 500;
    public $cropperOptions = [
        'minContainerWidth' => 400,
        'minContainerHeight' => 400,
        // viewMode: 3,
        // aspectRatio: finalAspectRatio,
        'zoomable' => true,
        'dragMode' => 'move',
    ];

    public $fixedSize = true;

    public function init() 
    {
        // your logic here
        parent::init();

        $this->uploadUrl = Url::to($this->uploadUrl);
        $this->modelName = App::getModelName($this->model);

        $this->parameters[App::request('csrfParam')] = App::request('csrfToken');
        $this->parameters['UploadForm[modelName]'] = $this->modelName;

        $this->defaultPhoto = Url::image(App::setting('image')->image_holder);
        $this->uploadFileName = $this->uploadFileName ?: $this->parameters['UploadForm[modelName]'];

        $this->extensions = $this->extensions ?: File::EXTENSIONS['image'];
        foreach ($this->extensions as $key => $extension) {
            $this->parameters["UploadForm[extensions][{$key}]"] = $extension;
        }

        if ($this->fixedSize) {
            $this->cropperOptions['aspectRatio'] = $this->finalCropWidth / $this->finalCropHeight;
        }
    } 
    
    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('image-gallery', [
            'attribute' => $this->attribute,
            'model' => $this->model,
            'modelName' => $this->modelName,
            'modalTitle' => $this->modalTitle,
            'buttonTitle' => $this->buttonTitle,
            'id' => $this->id,
            'uploadUrl' => $this->uploadUrl,
            'ajaxSuccess' => $this->ajaxSuccess,
            'ajaxError' => $this->ajaxError,
            'myImageFilesUrl' => Url::to($this->myImageFilesUrl),
            'defaultPhoto' => $this->defaultPhoto,
            'uploadFileName' => $this->uploadFileName,
            'parameters' => json_encode($this->parameters),
            'buttonOptions' => $this->buttonOptions,
            'extensions' => $this->extensions,
            'cropperOptions' => json_encode($this->cropperOptions),
            'finalCropWidth' => $this->finalCropWidth,
            'finalCropHeight' => $this->finalCropHeight,
        ]);
    }
}
