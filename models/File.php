<?php

namespace app\models;

use Imagine\Gd;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;
use Yii;
use app\helpers\App;
use app\helpers\Html;
use app\models\ModelFile;
use app\widgets\Anchor;
use app\helpers\Url;
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
    const EXTENSIONS = [
        'image' => ['jpeg', 'jpg', 'gif', 'bmp', 'tiff','png', 'ico',],
        'file' => ['doc', 'docx', 'pdf', 'xls', 'xlsx', 'csv', 'sql'],
    ];
    const IMAGE_HOLDER = 'https://via.placeholder.com/100';

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
            [['location'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['extension'], 'string', 'max' => 16],
            ['extension', 'in', 'range' => array_merge(
                self::EXTENSIONS['image'],
                self::EXTENSIONS['file'],
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

    public function getImageFiles()
    {
        return Files::find()
            ->where(['extension' => self::EXTENSIONS['image']])
            ->all();
    }

    public function getDisplayRootPath()
    {
        $doc_path = (App::isWeb()? Yii::getAlias('@webroot'): Yii::getAlias('@consoleWebroot')) 
            . '/default/file-preview/';

        return ($this->isImage)? $this->rootPath: $this->getDisplay([], false, $doc_path);
    }

    public function getDisplay($params = [], $fullpath=false, $path='@web/default/file-preview/')
    {
        switch ($this->extension) {
            case 'css': $path .= 'css.png'; break;
            case 'zip': $path .= 'zip.png'; break;
            case 'sql': $path .= 'sql.png'; break;
            case 'csv': $path .= 'csv.png'; break;
            case 'docx':
            case 'doc':
            case 'txt': 
                $path .= 'doc.png'; break;
            case 'html': $path .= 'html.png'; break;
            case 'js': $path .= 'js.png'; break;
            case 'mp4': $path .= 'mp4.png'; break;
            case 'pdf': $path .= 'pdf.png'; break;
            case 'xml': $path .= 'xml.png'; break;
            default:
                $path = array_merge(['file/display', 'token' => $this->token], $params);
                $path = Url::to($path, $fullpath);
                break;
        }

        return $path;
    }

    public function show($params=[], $w=150)
    {
        if ($this->isDocument) {
            $params['style'] = "width:200px;height:auto";

            return Html::img($this->display, $params);
        }
        else {
            return Html::img(['file/display', 'token' => $this->token, 'w' => $w,], $params);
        }
    }

    public function getPreviewImage()
    {
        return Html::image($this->token, [
            'w' => 50, 
            'h' => 50,
            'ratio' => 'false',
            'quality' => 90
        ], [
            'class' => 'img-thumbnail',
            'loading' => 'lazy'
        ]);
    }

    public function gridColumns()
    {
        return [
            'icon' => [
                'attribute' => 'name', 
                'label' => 'Preview', 
                'format' => 'raw',
                'value' => 'previewImage',
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
            'previewImage:raw',
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

    public function getRootPath()
    {
        $paths = [
            (App::isWeb()? Yii::getAlias('@webroot'): Yii::getAlias('@consoleWebroot')),
            $this->location
        ];

        return implode('/', $paths);
    }

    public function getIsDocument()
    {
        return in_array($this->extension, self::EXTENSIONS['file']);
    }

    public function getIsImage()
    {
        return in_array($this->extension, self::EXTENSIONS['image']);
    }

    public function getWidth()
    {
        return $this->dimension['width'];
    }

    public function getHeight()
    {
        return $this->dimension['height'];
    }

    public function getDimension()
    {
        $width = 0;
        $height = 0;

        if (file_exists($this->displayRootPath)) {
            list($width, $height) = getimagesize($this->displayRootPath);
        }
        return [
            'width' => ($this->isImage)? $width: 0,
            'height' => ($this->isImage)? $height: 0,
        ];
    }

    public function getImageRatio($w, $quality=100, $extension='png')
    {
        if (file_exists($this->displayRootPath)) {
            $imagineObj = new Imagine();
            $image = $imagineObj->open($this->displayRootPath);
            $image->resize($image->getSize()->widen($w));

            return $image->show($extension, ['quality' => $quality]); 
        }
    }

    public function getImageCrop($w, $h, $quality=100, $extension='png')
    {
        if (file_exists($this->displayRootPath)) {
            $image = Image::crop($this->displayRootPath, $w, $h); 

            return $image->show($extension, ['quality' => $quality]); 
        }
    }

    public function getImage($w, $h, $quality=100, $extension='png')
    {
        if (file_exists($this->displayRootPath)) {
            $image = Image::getImagine() 
                ->open($this->displayRootPath) 
                ->resize(new Box($w, $h));

            return $image->show($extension, ['quality' => $quality]);
        }
    }
    
    public function getIsSql()
    {
        return in_array($this->extension, ['sql']);
    }

    public function getCanDelete()
    {
        if ($this->extension == 'sql') {
            return false;
        }

        return parent::getCanDelete();
    }

    public function getDownloadUrl($scheme = false)
    {
        return Url::to(['file/download', 'token' => $this->token], $scheme);
    }

    public function download()
    {
        $file = $this->rootPath;
        if (file_exists($file)) {
            App::response()->sendFile($file, implode('.', [$this->name, $this->extension]));

            return true;
        }
        return false;
    }

    public static function findByToken($token)
    {
        return static::find()
            ->where(['token' => $token])
            ->one();
    }

    public static function findByKeywordsImage($keywords='', $attributes, $limit=3)
    {
        $data = [];
        foreach ($attributes as $attribute) {
            $data = array_merge($data, array_values(
                self::filter($attribute, ['and',
                    ['LIKE', $attribute, $keywords],
                    ['extension' => self::EXTENSIONS['image']],
                ], 3)
            ));
        }

        $data = array_unique($data);
        $data = array_values($data);
        
        sort($data);

        return $data;
    }

    public function getMimeType()
    {
        if ($this->isDocument) {
            return implode('/', ['file', $this->extension]);
        }

        return implode('/', ['image', $this->extension]);
    }
}