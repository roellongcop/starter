<?php

namespace app\models;

use Yii;
use app\helpers\App;
use app\widgets\Anchor;

/**
 * This is the model class for table "{{%user_metas}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $meta_key
 * @property string|null $meta_value
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class UserMeta extends ActiveRecord
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
        return '{{%user_metas}}';
    }

    public function controllerID()
    {
        return 'user-meta';
    }

    public function mainAttribute()
    {
        return 'meta_key';
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
            [['user_id', 'record_status', 'created_by', 'updated_by'], 'integer'],
            [['record_status'], 'default', 'value' => 1],
            ['record_status', 'in', 'range' => [parent::RECORD_ACTIVE, parent::RECORD_INACTIVE]],
            [['user_id'], 'default', 'value' => 0],
            [['meta_key', 'record_status'], 'required'],
            [['created_at', 'updated_at', 'meta_value'], 'safe'],
            [['meta_key'], 'string', 'max' => 255],
            ['user_id', 'exist', 'targetRelation' => 'user', 'message' => 'User not found'],
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

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getUsername()
    {
        if(($model = $this->user) != null) {
            return $model->username;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'meta_key' => 'Meta Key',
            'meta_value' => 'Meta Value',
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
     * @return \app\models\query\UserMetaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\UserMetaQuery(get_called_class());
    }
     
   

    public function gridColumns()
    {
        return [
            'user_id' => [
                'attribute' => 'user_id', 
                'format' => 'raw',
                'label' => 'username',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->username,
                        'link' => $model->user->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'meta_key' => [
                'attribute' => 'meta_key', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->meta_key,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'meta_value' => ['attribute' => 'meta_value', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            'user_id:raw',
            'meta_key:raw',
            'meta_value:raw',
        ];
    }
    
}
