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
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%themes}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'theme',
            'mainAttribute' => 'name',
            'paramName' => 'slug',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return $this->setRules([
            [['name', 'description', 'base_path', 'base_url'], 'required'],
            [['base_path', 'base_url'], 'string'],
            [['bundles', 'path_map', 'slug'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->setAttributeLabels([
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'base_path' => 'Base Path',
            'base_url' => 'Base Url',
            'path_map' => 'Path Map',
            'bundles' => 'Bundles',
        ]);
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