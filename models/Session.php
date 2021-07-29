<?php

namespace app\models;

use Yii;
use app\helpers\App;
use app\widgets\Anchor;
use app\helpers\Url;

/**
 * This is the model class for table "{{%sessions}}".
 *
 * @property string $id
 * @property int|null $expire
 * @property resource|null $data
 * @property int|null $user_id
 * @property string $ip
 * @property string $browser
 * @property string $os
 * @property string $device
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Session extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sessions}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'session',
            'mainAttribute' => 'browser',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return $this->setRules([
            [['id', 'ip', 'browser', 'os', 'device',], 'required'],
            [['ip',], 'ip'],
            [['expire', 'user_id',], 'integer'],
            [['data'], 'string'],
            [['id'], 'string', 'max' => 40],
            [['ip'], 'string', 'max' => 32],
            [['browser', 'os', 'device'], 'string', 'max' => 128],
            [['id'], 'unique'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->setAttributeLabels([
            'id' => 'ID',
            'expire' => 'Expire',
            'data' => 'Data',
            'user_id' => 'User ID',
            'ip' => 'Ip',
            'browser' => 'Browser',
            'os' => 'Os',
            'device' => 'Device',
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\SessionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\SessionQuery(get_called_class());
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

    public function gridColumns()
    {
        return [
            'id' => [
                'attribute' => 'id', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->id,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'expire' => ['attribute' => 'expire', 'format' => 'raw'],
            // 'data' => ['attribute' => 'data', 'format' => 'raw'],
            'username' => [
                'attribute' => 'username', 
                'format' => 'raw',
                'value' => function($model) {
                    if ($model->username) {
                        return Anchor::widget([
                            'title' => $model->username,
                            'link' => $model->user->viewUrl,
                            'text' => true
                        ]);
                    }

                    return "<span class='label label-lg label-light-primary label-inline'>
                        Guest
                    </span>";
                }
            ],
            'ip' => ['attribute' => 'ip', 'format' => 'raw'],
            'browser' => ['attribute' => 'browser', 'format' => 'raw'],
            'os' => ['attribute' => 'os', 'format' => 'raw'],
            'device' => ['attribute' => 'device', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            'expire:raw',
            'data:raw',
            'user_id:raw',
            'ip:raw',
            'browser:raw',
            'os:raw',
            'device:raw',
        ];
    }
}