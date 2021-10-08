<?php

namespace app\models\form;

use Yii;
use app\helpers\App;
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

    public function init()
    {
        parent::init();
        switch ($this->extensionType) {
            case 'image':
                $this->extensions = App::file('file_extensions')['image'];
                break;

            case 'file':
                $this->extensions = App::file('file_extensions')['file'];
                break;
            
            default:
                $this->extensions = array_merge(
                    App::file('file_extensions')['image'],
                    App::file('file_extensions')['file']
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
                return App::component('file')->upload($this, 'fileInput');
            } 
        }
        return false;
    }  
}