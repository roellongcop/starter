<?php

namespace app\models\form;

use Yii;
use app\helpers\App;
use app\models\File;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;
/**
 * This is the model class for table "{{%themes}}".
 *
 * @property int $id
 * @property string $name
 * @property string $folder
 * @property string|null $basePath
 * @property string|null $baseUrl
 * @property string|null $pathMap
 * @property string|null $bundles
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class UploadForm extends \yii\base\Model
{
    public $modelName;
    public $fileInput;
    public $fileToken;
    public $extensions;

    public $extensionType = '*';

    const FILE_EXTENSIONS = [
        'image' => ['jpeg', 'jpg', 'gif', 'bmp', 'tiff','png', 'ico',],
        'file' => ['doc', 'docx', 'pdf', 'xls', 'xlxs', 'csv', 'sql'],
    ];

    public function init()
    {
        parent::init();
        switch ($this->extensionType) {
            case 'image':
                $this->extensions = self::FILE_EXTENSIONS['image'];
                break;

            case 'file':
                $this->extensions = self::FILE_EXTENSIONS['file'];
                break;
            
            default:
                $this->extensions = array_merge(
                    self::FILE_EXTENSIONS['image'],
                    self::FILE_EXTENSIONS['file']
                );
                break;
        }
    }
  
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['modelName'], 'required'],
            [['modelName', 'fileToken'], 'string'],
            [['extensionType'], 'safe'],
            [
                ['fileInput'], 
                'file', 
                'skipOnEmpty' => false, 
                'extensions' => $this->extensions, 
                'checkExtensionByMimeType' => false
            ],
        ];
    } 

    public function upload()
    {
        if ($this->validate()) {
            if ($this->fileInput) {
                return $this->uploadFile($this, 'fileInput');
            } 
        }
        return false;
    }   


    public function uploadFile($model, $attribute="imageInput")
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

        do {
            $time = time();
            $string = App::randomString(10);
            $path = "{$file_path}/{$string}-{$time}.{$input->extension}";
        } while (file_exists($path));
        

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