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
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_metas}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'user-meta',
            'mainAttribute' => 'meta_key',
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return $this->setRules([
            [['user_id',], 'integer'],
            [['user_id'], 'default', 'value' => 0],
            [['meta_key', 'record_status'], 'required'],
            [['meta_value'], 'safe'],
            [['meta_key'], 'string', 'max' => 255],
            ['user_id', 'exist', 'targetRelation' => 'user', 'message' => 'User not found'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->setAttributeLabels([
            'id' => 'ID',
            'user_id' => 'User ID',
            'meta_key' => 'Meta Key',
            'meta_value' => 'Meta Value',
        ]);
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