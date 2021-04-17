<?php
namespace app\widgets;

use Yii;
use app\helpers\App;
use yii\helpers\Url;
 
class Dropzone extends \yii\base\Widget
{
    public $parameters = [];
    public $paramName = 'UploadForm[fileInput]';
    public $maxFiles = 10;
    public $maxFilesize = 10; // MB
    public $addRemoveLinks = true;
    public $url;
    public $title = 'Drop files here or click to upload.';
    public $description;
    public $dictRemoveFileConfirmation = 'Remove File ?';
    public $dictRemoveFile = 'Remove';

    public $model;
    public $removeFileUrl;
    public $complete;
    public $success;
    public $removedFile;
    public $acceptedFiles;
    public function init() 
    {
        // your logic here
        parent::init();

        if (!$this->description) {
            $this->description = "Upload up to {$this->maxFiles} files";
        }
        $this->parameters[App::request('csrfParam')] = App::request('csrfToken');

        $this->parameters['modelName'] = App::className($this->model);
        $this->parameters['id'] = $this->model->id ?: 0;

        $this->url = $this->url ?: Url::to(['file/upload']);
        $this->removeFileUrl = $this->removeFileUrl ?: Url::to(['file/delete']);

        if (!$this->removedFile) {
            $this->removedFile = "$.ajax({
                url: '{$this->removeFileUrl}',
                data: {fileToken: file.upload.uuid},
                method: 'post',
                dataType: 'json',
                cache: false,
                success: function(s) {
                    console.log('success')
                },
                error: function(e) {
                    console.log('error')
                }
            })";
        }

        if (!$this->acceptedFiles) {
            $acceptedFiles = array_merge(
                App::params('file_extensions')['image'],
                App::params('file_extensions')['file']
            );
            $this->acceptedFiles = array_map(function($val) { return ".{$val}"; }, $acceptedFiles);
        }

        if (is_array($this->acceptedFiles)) {
            $this->acceptedFiles = implode(',', $this->acceptedFiles);
        }
    }


    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('dropzone', [
            'id' => $this->id,
            'parameters' => json_encode($this->parameters),
            'paramName' => $this->paramName,
            'maxFiles' => $this->maxFiles,
            'maxFilesize' => $this->maxFilesize,
            'addRemoveLinks' => $this->addRemoveLinks,
            'url' => $this->url,
            'title' => $this->title,
            'description' => $this->description,
            'dictRemoveFileConfirmation' => $this->dictRemoveFileConfirmation,
            'removeFileUrl' => $this->removeFileUrl,
            'dictRemoveFile' => $this->dictRemoveFile,
            'complete' => $this->complete,
            'removedFile' => $this->removedFile,
            'acceptedFiles' => $this->acceptedFiles,
            'success' => $this->success,
        ]);
    }
}
