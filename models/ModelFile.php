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

    public function controllerID()
    {
        return 'model-file';
    }

    public function mainAttribute()
    {
        return 'id';
    }
    public function paramName()
    {
        return 'id';
    }
 
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model_id', 'file_id',], 'integer'],
            [['record_status'], 'default', 'value' => 1],
            ['record_status', 'in', 'range' => [parent::RECORD_ACTIVE, parent::RECORD_INACTIVE]],
            [['model_id', 'file_id'], 'default', 'value' => 0],
            [['model_name', 'record_status'], 'required'],
            [['record_status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['model_name'], 'string', 'max' => 255],
            ['file_id', 'exist', 'targetRelation' => 'file'],
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
     
     

    public function gridColumns()
    {
        return [
            'model_id' => [
                'attribute' => 'model_id', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->model_id,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'file_id' => ['attribute' => 'file_id', 'format' => 'raw'],
            'model_name' => ['attribute' => 'model_name', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            'model_id:raw',
            'file_id:raw',
            'model_name:raw',
        ];
    }

    public function getFile()
    {
        return $this->hasOne(File::className(), ['id' => 'file_id']);
    }

    public function getFileToken()
    {
        if (($file = $this->file) != null) {
            return $file->token;
        }
    }

    public function getFileLocation()
    {
        if (($file = $this->file) != null) {
            return $file->location;
        }
    }
}
