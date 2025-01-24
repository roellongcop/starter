<?php

namespace app\models;

use app\helpers\App;
use app\widgets\Anchor;

/**
 * This is the model class for table "{{%user_metas}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string|null $value
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
            'mainAttribute' => 'name',
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
            [['name'], 'required'],
            [['value'], 'safe'],
            [['name'], 'string', 'max' => 255],
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
            'name' => 'Meta Key',
            'value' => 'Meta Value',
        ]);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getUsername()
    {
        return App::if ($this->user, fn($user) => $user->username);
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
                'value' => function ($model) {
                    return Anchor::widget([
                        'title' => $model->username,
                        'link' => $model->user->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'name' => [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function ($model) {
                    return Anchor::widget([
                        'title' => $model->name,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'value' => ['attribute' => 'value', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            'user_id:raw',
            'name:raw',
            'value:raw',
        ];
    }

    public static function findByKeywords($keywords = '', $attributes = [], $limit = 10, $andFilterWhere = [])
    {
        return parent::findByKeywordsData($attributes, fn($attribute) => self::find()
            ->select("{$attribute} AS data")
            ->alias('um')
            ->joinWith('user u')
            ->groupBy($attribute)
            ->where(['LIKE', $attribute, explode(' ', $keywords)])
            ->andFilterWhere($andFilterWhere)
            ->limit($limit)
            ->asArray()
            ->all());
    }
}
