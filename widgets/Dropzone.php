<?php

namespace app\widgets;

use Yii;
use app\helpers\App;
use app\helpers\Url;
use yii\helpers\ArrayHelper;
 
class Dropzone extends AppWidget
{
    public $parameters = [];
    public $paramName = 'UploadForm[fileInput]';
    public $maxFiles = 10;
    public $maxFilesize = 10; // MB
    public $addRemoveLinks = true;
    public $url = ['file/upload'];
    public $title = 'Drop files here or click to upload.';
    public $description;
    public $dictRemoveFileConfirmation = 'Remove File ?';
    public $dictRemoveFile = 'Remove';

    public $model;
    public $removeFileUrl = ['file/delete'];
    public $complete;
    public $success;
    public $removedFile;
    public $acceptedFiles;

    public $hiddenInput = true;
    public $files = [];
    public $inputName;


    public function init() 
    {
        // your logic here
        parent::init();
        $this->inputName = $this->inputName ?: App::controller('inputName');

        if (!$this->description) {
            $this->description = "Upload up to {$this->maxFiles} file(s)";
        }
        $this->parameters[App::request('csrfParam')] = App::request('csrfToken');

        $this->parameters['UploadForm[modelName]'] = App::className($this->model);
        $this->parameters['UploadForm[id]'] = $this->model->id ?: 0;

        $this->url = Url::to($this->url);
        $this->removeFileUrl = Url::to($this->removeFileUrl);


        if (!$this->removedFile) {
            $this->removedFile = "$.ajax({
                url: '{$this->removeFileUrl}',
                data: {fileToken: file.upload.uuid},
                method: 'post',
                dataType: 'json',
                cache: false,
                success: function(s) {
                    let inp = $('input[data-uuid=\"'+ file.upload.uuid +'\"]');

                    if(inp.length) {
                        inp.remove();
                    }
                },
                error: function(e) {
                    console.log(e)
                }
            })";
        }

        if (!$this->acceptedFiles) {
            $acceptedFiles = array_merge(
                App::file('file_extensions')['image'],
                App::file('file_extensions')['file']
            );
            $this->acceptedFiles = array_map(function($val) { return ".{$val}"; }, $acceptedFiles);
        }

        if (is_array($this->acceptedFiles)) {
            $this->acceptedFiles = implode(',', $this->acceptedFiles);
        }

        if ($this->hiddenInput) {
            $this->success .= "
                $(\"#dropzone-{$this->id}\").append(\"<input name='{$this->inputName}[]' data-uuid='\"+ file.upload.uuid +\"' type='hidden' value='\"+ s.file.id +\"'> \");
            ";
        }

        if ($this->files) {
            $this->files = ArrayHelper::toArray($this->files, [
                'app\models\File' => [
                    'id',
                    'size',
                    'token',
                    'extension',
                    'name',
                    'location',
                    'upload' => function($model) {
                        return [
                            'uuid' => $model->token
                        ];
                    },
                    'fullname' => function($model) {
                        return implode('.', [$model->name, $model->extension]);
                    },
                    'imagePath' => function($model) {
                        return $model->display([
                            'w' => 120, 
                            'quality' => 90,
                            // 'h' => 120, 
                            // 'crop' => 'true',
                            // 'ratio' => 'false',
                        ]);
                    }
                ]
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('dropzone', [
            'files' => json_encode($this->files),
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
            'hiddenInput' => $this->hiddenInput
        ]);
    }
}
