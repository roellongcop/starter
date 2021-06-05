<?php

namespace app\models;

use Yii;
use app\helpers\App;
use app\helpers\Html;
use app\widgets\Anchor;
use app\widgets\AppImages;
use app\widgets\Dropzone;
use app\widgets\JsonEditor;
use yii\behaviors\SluggableBehavior;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%themes}}".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string|null $base_path
 * @property string|null $base_url
 * @property string|null $path_map
 * @property string|null $bundles
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Theme extends ActiveRecord
{
    public $relatedModels = [];
    //public $excel_ignore_attr = [];
    //public $fileInput;
    public $imageInput;
    //public $fileLocation; 

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%themes}}';
    }

    public function controllerID()
    {
        return 'theme';
    }
 
    public function mainAttribute()
    {
        return 'name';
    }

    public function paramName()
    {
        return 'slug';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'base_path', 'base_url', 'record_status'], 'required'],
            [['record_status'], 'default', 'value' => 1],
            ['record_status', 'in', 'range' => [parent::RECORD_ACTIVE, parent::RECORD_INACTIVE]],
            [['base_path', 'base_url'], 'string'],
            [['record_status', 'created_by', 'updated_by'], 'integer'],
            [['bundles', 'path_map', 'slug'], 'safe'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            /*[
                ['fileInput'], 
                'file', 
                'skipOnEmpty' => true, 
                'extensions' => App::params('file_extensions')['file'], 
                'checkExtensionByMimeType' => false
            ],
            */
            [
                ['imageInput'], 
                'image', 
                // 'minWidth' => 100,
                // 'maxWidth' => 200,
                // 'minHeight' => 100,
                // 'maxHeight' => 200,
                'maxSize' => 1024 * 1024 * 2,
                'skipOnEmpty' => true, 
                'extensions' => App::params('file_extensions')['image'], 
                'checkExtensionByMimeType' => false
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'base_path' => 'Base Path',
            'base_url' => 'Base Url',
            'path_map' => 'Path Map',
            'bundles' => 'Bundles',
            'record_status' => 'Record Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'recordStatusHtml' => 'Record Status',
            'recordStatusLabel' => 'Record Status',
        ];
    }


    /**
     * {@inheritdoc}
     * @return \app\models\query\ThemeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ThemeQuery(get_called_class());
    }

    public function getActivateUrl()
    {
        return Url::to(['theme/activate', 'slug' => $this->slug], true);
    }
     
     

    public function gridColumns()
    {
        return [
            'preview' => [
                'attribute' => 'name', 
                'label' => 'preview', 
                'format' => 'raw',
                'value' => 'previewImage'
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
            'description' => ['attribute' => 'description', 'format' => 'raw'],
            // 'base_path' => ['attribute' => 'base_path', 'format' => 'raw'],
            // 'base_url' => ['attribute' => 'base_url', 'format' => 'raw'],
            // 'path_map' => ['attribute' => 'path_map', 'format' => 'raw'],
            // 'bundles' => ['attribute' => 'bundles', 'format' => 'raw'],
        ];
    }

    public function getpath_mapdata()
    {
        return JsonEditor::widget([
            'data' => $this->path_map,
        ]);
    }

    public function getBundlesdata()
    {
        return JsonEditor::widget([
            'data' => $this->bundles,
        ]);
    }

    public function detailColumns()
    {
        return [
            'name:raw',
            'description:raw',
            'base_path:raw',
            'base_url:raw',
            'path_mapData:raw',
            'bundlesData:raw',
            'previewImages:raw',
        ];
    }

    public function getUploadImages()
    {
        return Dropzone::widget([
            'url' => Url::to(['theme/upload-image']),
            'paramName' => 'Theme[imageInput]',
            'parameters' => [
                'Theme[id]' => $this->id
            ]
        ]);
    }

    public function getPreviewImage()
    {
        return Html::img($this->imagePath . '&w=100');
    }

    public function getPreviewImages()
    {
        return AppImages::widget(['model' => $this]);
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['JsonBehavior']['fields'] = [
            'path_map', 
            'bundles',
        ];

        $behaviors['SluggableBehavior'] = [
            'class' => SluggableBehavior::className(),
            'attribute' => 'name',
            'slugAttribute' => 'slug',
            'immutable' => false,
            'ensureUnique' => true,
        ];
        return $behaviors;
    }
}
