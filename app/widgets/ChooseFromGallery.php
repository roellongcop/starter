<?php
namespace app\widgets;

use Yii;
use app\helpers\App;
use yii\helpers\Url;
 
class ChooseFromGallery extends \yii\base\Widget
{
    public $file_id;
    public $modalTitle = 'Choose from Gallery';
    public $buttonTitle = 'Choose from Gallery';
    public $files;
    public $chooseImageUrl = ['file/choose-from-gallery'];
    public $uploadUrl = ['file/upload'];
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

        $this->chooseImageUrl = Url::to($this->chooseImageUrl);
        $this->uploadUrl = Url::to($this->uploadUrl);
        $this->files = $this->files ?: App::identity('myImageFiles');
    }


    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('choose_from_gallery', [
            'modalTitle' => $this->modalTitle,
            'buttonTitle' => $this->buttonTitle,
            'id' => $this->id,
            'files' => $this->files,
            'chooseImageUrl' => $this->chooseImageUrl,
            'uploadUrl' => $this->uploadUrl,
            'ajaxSuccess' => $this->ajaxSuccess,
            'ajaxError' => $this->ajaxError,
            'dropzoneComplete' => $this->dropzoneComplete,
            'fileInput' => $this->fileInput,
            'dropzoneSuccess' => $this->dropzoneSuccess,
            'myImageFilesUrl' => Url::to($this->myImageFilesUrl),
            'file_id' => $this->file_id,
        ]);
    }
}
