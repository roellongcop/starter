<?php
namespace app\components;

use Yii;
use app\helpers\App;
use app\models\File;
use yii\base\Component;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;

/**
 * 
 */
class FileComponent extends Component
{
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
        $file            = new File();
        $file->name      = $input->baseName;
        $file->location  = $location;
        $file->extension = $input->extension;
        $file->size      = $input->size;
        $file->model     = ($model->modelName ?? App::className($model));
        $file->model_id  = $model->id;
        $file->token  = ($model->fileToken ?? '');

        if ($file->save()) {
            return $file;
        }
        else {
            App::danger(json_encode($file->errors));
        }
    }
 
 

    public function uploadPath($model, $input)
    {
        $folders = [
            'uploads',
            date('Y'),
            date('m'),
        ];

        if (isset($model->modelName)) {
            $folders[] = strtolower(Inflector::slug($model->modelName));
        }
        else {
            $folders[] = strtolower(Inflector::slug(App::className($model)));
        }


        $file_path = implode('/', $folders);
        FileHelper::createDirectory($file_path);

        $time = time();
        $string = App::randomString(10);
        // $path = "{$file_path}/{$input->baseName}-{$time}.{$input->extension}";
        $path = "{$file_path}/{$string}-{$time}.{$input->extension}";

        $this->createIndexFile($folders);

        return $path;
    }

    public function createIndexFile($folders)
    {
        $path = Yii::getAlias('@webroot') . '/';
            
        foreach ($folders as $folder) {
            $path .=  "{$folder}/";

            if (! file_exists($path . 'index.php')) {
                $index_file = fopen($path . 'index.php', "w");
                fwrite($index_file, "Forbidden Access");
                fclose($index_file);
            }
        }
    } 
}