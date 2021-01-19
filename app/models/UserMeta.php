<?php

namespace app\models;

use Yii;
use app\behaviors\JsonBehavior;
use app\helpers\App;
use app\models\search\SettingSearch;
use app\widgets\Anchor;
use yii\behaviors\AttributeTypecastBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\Inflector;
use yii\helpers\Url;

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
 

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'record_status', 'created_by', 'updated_by'], 'integer'],
            [['record_status'], 'default', 'value' => 1],
            [['user_id'], 'default', 'value' => 0],
            [['meta_key', 'record_status'], 'required'],
            [['meta_value'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
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
     
   

    public function tableColumns()
    {
        return [
            'serial' => [
                'class' => 'yii\grid\SerialColumn',
            ],
            'checkbox' => ['class' => 'app\widgets\CheckboxColumn'],
            'user_id' => [
                'attribute' => 'user_id', 
                'format' => 'raw',
                'label' => 'username',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->username,
                        'link' => ['user/view', 'id' => $model->user_id],
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
                        'link' => ['view', 'id' => $model->id],
                        'text' => true
                    ]);
                }
            ],
            'meta_value' => ['attribute' => 'meta_value', 'format' => 'raw'],
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
            'user_id:raw',
            'meta_key:raw',
            'meta_value:raw',
			'created_at:fulldate',
            'updated_at:fulldate',
            'createdByEmail',
            'updatedByEmail',
            'recordStatusHtml:raw'
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('UTC_TIMESTAMP'),
            ],
            [
                'class' => BlameableBehavior::className(),
                'defaultValue' => 0
            ],
            ['class' => AttributeTypecastBehavior::className()],
            ['class' => JsonBehavior::className()], 
        ];
    }
    
}
