<?php

namespace app\models;

use Yii;
use app\helpers\App;
use app\widgets\Anchor;
use yii\helpers\Inflector;
use yii\helpers\Url;
use app\models\query\ModelFileQuery;

/**
 * This is the model class for table "{{%model_files}}".
 *
 * @property int $id
 * @property int $model_id
 * @property int $file_id
 * @property string $model
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class ModelFile extends ActiveRecord
{
    public $relatedModels = [];
    //public $excel_ignore_attr = [];
    //public $fileInput;
    //public $imageInput;
    //public $fileLocation; 

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%model_files}}';
    }
 


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model_id', 'file_id',], 'integer'],
            [['record_status'], 'default', 'value' => 1],
            [['model_id', 'file_id'], 'default', 'value' => 0],
            [['model_name', 'record_status'], 'required'],
            [['record_status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['model_name'], 'string', 'max' => 255],
            /*[
                ['fileInput'], 
                'file', 
                'skipOnEmpty' => true, 
                'extensions' => App::params('file_extensions')['file'], 
                'checkExtensionByMimeType' => false
            ],
            [
                ['imageInput'], 
                'image', 
                'minWidth' => 100,
                'maxWidth' => 200,
                'minHeight' => 100,
                'maxHeight' => 200,
                'maxSize' => 1024 * 1024 * 2,
                'skipOnEmpty' => true, 
                'extensions' => App::params('file_extensions')['image'], 
                'checkExtensionByMimeType' => false
            ],
            */
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model_id' => 'Model ID',
            'file_id' => 'File ID',
            'model_name' => 'Model',
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
     * @return \app\models\query\ModelFileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ModelFileQuery(get_called_class());
    }
     
     

    public function getTableColumns()
    {
        return [
            'serial' => [
                'class' => 'yii\grid\SerialColumn',
            ],
            'checkbox' => ['class' => 'app\widgets\CheckboxColumn'],
            'model_id' => [
                'attribute' => 'model_id', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->model_id,
                        'link' => ['model-file/view', 'id' => $model->id],
                        'text' => true
                    ]);
                }
            ],
            'file_id' => ['attribute' => 'file_id', 'format' => 'raw'],
            'model_name' => ['attribute' => 'model_name', 'format' => 'raw'],
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

    public function getDetailColumns()
    {
        return [
            'model_id:raw',
            'file_id:raw',
            'model_name:raw',
			'created_at:fulldate',
			'updated_at:fulldate',
            'createdByEmail',
            'updatedByEmail',
            'recordStatusHtml:raw'
        ];
    }
}
