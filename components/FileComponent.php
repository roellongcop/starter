<?php

namespace app\components;

use Yii;
use app\helpers\App;
use app\models\File;
use app\models\ModelFile;
use yii\base\Component;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;

class FileComponent extends Component
{
    public $file_extensions = [
        'image' => ['jpeg', 'jpg', 'gif', 'bmp', 'tiff','png', 'ico',],
        'file' => ['doc', 'docx', 'pdf', 'xls', 'xlxs', 'csv', 'sql'],
    ];

    public function upload($model, $attribute="imageInput")
    {
        if (isset($model->{$attribute})) {
            $fileInput = $model->{$attribute};
            if ($fileInput) {
                $path = $this->uploadPath($model, $fileInput);
                
                $fileInput->saveAs($path);

                return $this->saveFile($model, $fileInput, $path);
            } 
        }
    }

    public function saveFile($model, $input, $location='')
    {
        $file = new File();
        $file->name = $input->baseName;
        $file->location = $location;
        $file->extension = $input->extension;
        $file->size = $input->size;

        if ($model->hasProperty('fileToken') && $model->fileToken) {
            $file->token = $model->fileToken;
        }

        if ($file->save()) {
            return $file;
        }
    }

    public function uploadPath($model, $input)
    {
        $folders = [
            'protected',
            'uploads',
            date('Y'),
            date('m'),
        ];

        $slug = $model->modelName ?? App::className($model);
        $folders[] = strtolower(Inflector::slug($slug));

        $this->createDirectory($folders);
        $this->createIndexFile($folders);

        $file_path = implode('/', $folders);
        $time = time();
        $string = App::randomString(10);
        $path = "{$file_path}/{$input->baseName}-{$time}.{$input->extension}";
        $path = "{$file_path}/{$string}-{$time}.{$input->extension}";

        return $path;
    }

    public function createDirectory($folders)
    {
        if (! App::isWeb()) {
            array_unshift($folders, Yii::getAlias('@consoleWebroot'));
        }
        $file_path = implode('/', $folders);
        FileHelper::createDirectory($file_path);
    }

    public function createHtaccessFile($path)
    {
        $content = "#disable directory browsing \nOptions -Indexes\n\n#prevent folder listing\nIndexIgnore *\n\n#If you want to deny access to all files: \n#deny from all";
        // $content = "#If you want to deny access to all files: \ndeny from all";

        if (! file_exists($path . '.htaccess')) {
            $htaccess = fopen($path . '.htaccess', "w");
            fwrite($htaccess, $content);
            fclose($htaccess);
        }
    }

    public function createIndexFile($folders)
    {
        $path = (App::isWeb()? Yii::getAlias('@webroot'): Yii::getAlias('@consoleWebroot')) . '/';

            
        foreach ($folders as $folder) {
            $path .=  "{$folder}/";

            $this->createHtaccessFile($path);
            if (! file_exists($path . 'index.php')) {
                $index_file = fopen($path . 'index.php', "w");
                fwrite($index_file, "Forbidden Access");
                fclose($index_file);
            }
        }
    } 
}