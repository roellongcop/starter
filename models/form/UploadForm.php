<?php

namespace app\models\form;

use Yii;
use app\helpers\App;
use app\models\File;
use yii\helpers\Inflector;
use yii\helpers\FileHelper;
use yii\helpers\StringHelper;

class UploadForm extends \yii\base\Model
{
    public $modelName;
    public $fileInput;
    public $token;
    public $extensions;
    public $tag;

    public function init()
    {
        parent::init();
        $this->extensions = $this->extensions ?: array_merge(
            File::EXTENSIONS['image'],
            File::EXTENSIONS['file']
        );
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['modelName'], 'required'],
            [['modelName', 'token', 'tag'], 'string'],
            [['extensions'], 'validateExtensions'],
            [
                ['fileInput'],
                'file',
                'skipOnEmpty' => false,
                'extensions' => $this->extensions,
                'checkExtensionByMimeType' => false
            ],
        ];
    }

    public function validateExtensions($attribute, $params)
    {
        if (($fileInput = $this->fileInput) != null) {
            if (!in_array($fileInput->extension, $this->extensions)) {
                $this->addError($attribute, 'File Extension Invalid');
            }
        }
    }

    public function upload()
    {
        if ($this->validate()) {
            if ($this->fileInput) {
                $path = $this->uploadPath($this, $this->fileInput);

                $this->fileInput->saveAs($path);

                return $this->saveFile($path);
            }
        }
        return false;
    }

    public function saveFile($location = '')
    {
        $input = $this->fileInput;

        $file = new File([
            'name' => StringHelper::truncate($input->baseName, 255),
            'tag' => $this->tag ?: ($this->modelName ?: App::className($this)),
            'location' => str_replace('\\', '/', $location),
            'extension' => $input->extension,
            'size' => $input->size,
            // 'token' => $this->token ?: ''
        ]);

        if ($file->save()) {
            return $file;
        } else {
            $this->addError('file', $file->errors);
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

        $file_path = implode(DIRECTORY_SEPARATOR, $folders);

        do {
            $time = time();
            $string = App::randomString(10);
            $path = "{$file_path}" . DIRECTORY_SEPARATOR . "{$input->baseName}-{$string}-{$time}.{$input->extension}";
        } while (file_exists($path));

        return $path;
    }

    public function createDirectory($folders)
    {
        if (!App::isWeb()) {
            array_unshift($folders, Yii::getAlias('@consoleWebroot'));
        }
        $file_path = implode(DIRECTORY_SEPARATOR, $folders);
        FileHelper::createDirectory($file_path);
    }

    public function createHtaccessFile($path)
    {
        $content = "#disable directory browsing \nOptions -Indexes\n\n#prevent folder listing\nIndexIgnore *\n\n#If you want to deny access to all files: \n#deny from all";
        // $content = "#If you want to deny access to all files: \ndeny from all";

        if (!file_exists($path . '.htaccess')) {
            $htaccess = fopen($path . '.htaccess', "w");
            fwrite($htaccess, $content);
            fclose($htaccess);
        }
    }

    public function createIndexFile($folders)
    {
        $path = (App::isWeb() ? Yii::getAlias('@webroot') : Yii::getAlias('@consoleWebroot')) . DIRECTORY_SEPARATOR;

        foreach ($folders as $folder) {
            $path .= "{$folder}" . DIRECTORY_SEPARATOR;

            $this->createHtaccessFile($path);
            if (!file_exists($path . 'index.php')) {
                $index_file = fopen($path . 'index.php', "w");
                fwrite($index_file, "Forbidden Access");
                fclose($index_file);
            }
        }
    }
}