<?php

namespace app\models;

use Imagine\Gd;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;
use Yii;
use app\helpers\App;
use app\helpers\Html;
use app\helpers\Url;
use app\models\ModelFile;
use app\models\form\UploadForm;
use app\widgets\Anchor;
use yii\imagine\Image;

/**
 * This is the model class for table "{{%files}}".
 *
 * @property int $id
 * @property string $name
 * @property string $extension
 * @property int $size
 * @property string|null $location
 * @property string $token
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class File extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%files}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'file',
            'mainAttribute' => 'name',
            'paramName' => 'token',
            'excelIgnoreAttributes' => ['icon']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return $this->setRules([
            [['size',], 'integer'],
            [['name', 'extension', 'size',], 'required'],
            [['token'], 'unique'],
            [['location'], 'string'],
            [['name', 'token'], 'string', 'max' => 255],
            [['extension'], 'string', 'max' => 16],
            ['extension', 'in', 'range' => array_merge(
                UploadForm::FILE_EXTENSIONS['image'],
                UploadForm::FILE_EXTENSIONS['file'],
            )],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->setAttributeLabels([
            'id' => 'ID',
            'model_id' => 'Model ID',
            'model' => 'Model',
            'name' => 'Name',
            'extension' => 'Extension',
            'size' => 'Size',
            'location' => 'Location',
            'token' => 'Token',
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\FileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\FileQuery(get_called_class());
    }

    public function getDocumentPreviewPath($params=[])
    {
        $path = '@web/default/file-preview/';

        switch ($this->extension) {
            case 'css':
                $path .= 'css.svg';
                break;
            case 'zip':
                $path .= 'zip.svg';
                break;
            case 'sql':
                $path .= 'sql.png';
                break;

            case 'csv':
                $path .= 'csv.svg';
                break;

            case 'docx':
            case 'doc':
            case 'txt':
                $path .= 'doc.svg';
                break;

            case 'html':
                $path .= 'html.svg';
                break;

            case 'javacript':
                $path .= 'javacript.svg';
                break;

            case 'mp4':
                $path .= 'mp4.svg';
                break;

            case 'pdf':
                $path .= 'pdf.svg';
                break;

            case 'xml':
                $path .= 'xml.svg';
                break;
            
            default:
                $path = $this->getImagePath($params);
                break;
        }

        return $path;
    }
    
    public function getPreviewIcon($w=60)
    {
        $options = ['w' => $w];
        $params = [
            'w' => $w, 
            'quality' => 50
        ];

        return Html::photo($this, $params, $options);
    }

    public function getImageFiles()
    {
        return Files::find()
            ->where(['extension' => UploadForm::FILE_EXTENSIONS['image']])
            ->all();
    }

    public function getDisplay($params = [])
    {
        if($this->token) {
            $path = array_merge(['file/display', 'token' => $this->token], $params);
            return Url::to($path);
        }
    }

    public function getImagePath($params = [])
    {
        return $this->getDisplay($params) ?: App::setting('image')->imageHolderPath;
    }

    public function gridColumns()
    {
        return [
            'icon' => [
                'attribute' => 'name', 
                'label' => 'Preview', 
                'format' => 'raw',
                'value' => 'previewIcon',
            ],

            'name' => [
                'attribute' => 'name', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->name,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            
            'extension' => ['attribute' => 'extension', 'format' => 'raw'],
            'size' => ['attribute' => 'size', 'format' => 'fileSize'],
            'location' => ['attribute' => 'location', 'format' => 'raw'],
            // 'token' => ['attribute' => 'token', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            'previewIcon:raw',
            'name:raw',
            'extension:raw',
            'size:raw',
            'location:raw',
            'token:raw',
        ];
    }

    public function getFileSize()
    {
        return App::formatter('asFileSize', $this->size);
    }

    public function getRootPath($value='')
    {
        $paths = [
            Yii::getAlias('@webroot'),
            $this->location
        ];

        return implode('/', $paths);
    }

    public function getIsDocument()
    {
        return in_array($this->extension, UploadForm::FILE_EXTENSIONS['file']);
    }

    public function getIsImage()
    {
        return in_array($this->extension, UploadForm::FILE_EXTENSIONS['image']);
    }

    public function getWidth()
    {
        return $this->dimension['width'];
    }

    public function getHeight()
    {
        return $this->dimension['height'];
    }

    public function getDimension($value='')
    {
        if (file_exists($this->rootPath)) {
            list($width, $height) = getimagesize($this->rootPath);
        }
        return [
            'width' => $width ?? 0,
            'height' => $height ?? 0,
        ];
    }

    public function getImageRatio($w, $quality=100, $extension='png')
    {
        if (file_exists($this->rootPath)) {
            $imagineObj = new Imagine();
            $image = $imagineObj->open($this->rootPath);
            $image->resize($image->getSize()->widen($w));

            return $image->show($extension, ['quality' => $quality]); 
        }
    }

    public function getImageCrop($w, $h, $quality=100, $extension='png')
    {
        if (file_exists($this->rootPath)) {
            $image = Image::crop($this->rootPath, $w, $h); 

            return $image->show($extension, ['quality' => $quality]); 
        }
    }

    public function getImage($w, $h, $quality=100, $extension='png')
    {
        if (file_exists($this->rootPath)) {
            $image = Image::getImagine() 
                ->open($this->rootPath) 
                ->resize(new Box($w, $h));

            return $image->show($extension, ['quality' => $quality]);
        }
    }

    public function getPathNoExt($path='')
    {
        $path = $path ?: $this->rootPath;

        $explodedPath = explode('.', $path);
        array_pop($explodedPath);
        $path = implode('', $explodedPath);


        return $path;
    }
    
    public function getIsSql()
    {
        return in_array($this->extension, ['sql']);
    }

    public function afterDelete()
    {
        ModelFile::deleteAll(['file_id' => $this->id]);
        // if (file_exists($this->rootPath)) {
        //     unlink($this->rootPath);
        // }
    }

    public function getCanDelete()
    {
        if ($this->extension == 'sql') {
            return false;
        }

        return parent::getCanDelete();
    }

    public function download()
    {
        $file = $this->location;
        if (file_exists($file)) {
            App::response()->sendFile($file, implode('.', [$this->name, $this->extension]));

            return true;
        }
        return false;
    }
}