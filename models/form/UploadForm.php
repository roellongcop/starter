<?php
namespace app\models\form;

use Yii;
use app\helpers\App;
use yii\base\Model;
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
class UploadForm extends Model
{
    public $id;
    public $modelName;
    public $fileInput;
    public $fileToken;

    public $extensionType = '*';
    public $extensions;

    public function init()
    {
        parent::init();
        switch ($this->extensionType) {
            case 'image':
                $this->extensions = App::params('file_extensions')['image'];
                break;

            case 'file':
                $this->extensions = App::params('file_extensions')['file'];
                break;
            
            default:
                $this->extensions = array_merge(
                    App::params('file_extensions')['image'],
                    App::params('file_extensions')['file']
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
            [['modelName', 'id', 'fileToken'], 'required'],
            [
                ['fileInput'], 
                'file', 
                // 'minWidth' => 100,
                // 'maxWidth' => 200,
                // 'minHeight' => 100,
                // 'maxHeight' => 200,
                // 'maxSize' => 1024 * 1024 * 2,
                'skipOnEmpty' => true, 
                'extensions' => $this->extensions, 
                'checkExtensionByMimeType' => false
            ],
        ];
    } 

    public function upload()
    {
        if ($this->fileInput) {
            // $this->fileToken = implode('-', [$this->fileToken, App::session('ID')]);
            return App::component('file')->upload($this, 'fileInput');
        } 
    }  
}