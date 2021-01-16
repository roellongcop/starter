<?php

namespace app\models;

use Yii;
use app\helpers\App;
use app\models\search\SettingSearch;
use app\widgets\Anchor;
use app\widgets\Dropzone;
use app\widgets\JsonEditor;
use app\widgets\AppImages;
use yii\behaviors\SluggableBehavior;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%themes}}".
 *
 * @property int $id
 * @property string $name
 * @property string $description
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
class Theme extends MainModel
{
    public $arrayAttr = ['pathMap', 'bundles'];
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
 


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'basePath', 'baseUrl'], 'required'],
            [['basePath', 'baseUrl'], 'string'],
            [['record_status', 'created_by', 'updated_by'], 'integer'],
            [['bundles', 'pathMap'], 'safe'],
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
            'basePath' => 'Base Path',
            'baseUrl' => 'Base Url',
            'pathMap' => 'Path Map',
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
     
     

    public function tableColumns()
    {
        return [
            'serial' => [
                'class' => 'yii\grid\SerialColumn',
            ],
            'checkbox' => ['class' => 'app\widgets\CheckboxColumn'],
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
                        'link' => ['view', 'id' => $model->id],
                        'text' => true
                    ]);
                }
            ],
            'description' => ['attribute' => 'description', 'format' => 'raw'],
            // 'basePath' => ['attribute' => 'basePath', 'format' => 'raw'],
            // 'baseUrl' => ['attribute' => 'baseUrl', 'format' => 'raw'],
            // 'pathMap' => ['attribute' => 'pathMap', 'format' => 'raw'],
            // 'bundles' => ['attribute' => 'bundles', 'format' => 'raw'],
            'created_at' => [
                'attribute' => 'created_at',
                'format' => 'fulldate',
            ],
            'last_updated' => [
                'attribute' => 'updated_at',
                'label' => 'last updated',
                'format' => 'ago',
            ],
            'active' => [
                'attribute' => 'record_status',
                'label' => 'active',
                'format' => 'raw', 
                'value' => 'recordStatusHtml'
            ],
        ];
    }

    public function getPathMapdata()
    {
        return JsonEditor::widget([
            'data' => $this->pathMap,
        ]);
    }

    public function getBundlesdata()
    {
        return JsonEditor::widget([
            'data' => $this->bundles,
        ]);
    }

    public function getDetailColumns()
    {
        return [
            'name:raw',
            'description:raw',
            'basePath:raw',
            'baseUrl:raw',
            'pathMapData:raw',
            'bundlesData:raw',
			'created_at:fulldate',
			'updated_at:fulldate',
            'createdByEmail',
            'updatedByEmail',
            'recordStatusHtml:raw',
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
    /**
    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'id',
                'slugAttribute' => 'slug',
                'immutable' => false,
                'ensureUnique' => true,
            ],
        ];
    } 
    */
}
