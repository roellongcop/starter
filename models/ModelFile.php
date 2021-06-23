<?php

namespace app\models;

use Yii;
use app\helpers\App;
use app\widgets\Anchor;
use yii\helpers\Inflector;
use yii\helpers\Url;

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
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%model_files}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'model-file',
        ];
    }
 
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return $this->setRules([
            [['model_id', 'file_id',], 'integer'],
            [['model_id', 'file_id'], 'default', 'value' => 0],
            [['model_id', 'model_name',], 'required'],
            [['model_name'], 'string', 'max' => 255],
            ['file_id', 'exist', 'targetRelation' => 'file'],
            ['model_id', 'validateModelId',],
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
            'file_id' => 'File ID',
            'model_name' => 'Model',
        ]);
    }

    public function validateModelId($attribute, $params)
    {
        if (!$this->modelInstance) {
            $this->addError($attribute, 'No Model name');
        }
        else {
            if (($model = $this->modelInstance::findOne($this->model_id)) == null) {
                $this->addError($attribute, 'Not Existing Model ID');
            }
        }
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\ModelFileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ModelFileQuery(get_called_class());
    }

    public function getModelInstance()
    {
        if ($this->model_name) {
            $class = Yii::createObject("\\app\\models\\{$this->model_name}");
            
            return $this->hasOne($class::className(), ['id' => 'model_id']);
        }
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
