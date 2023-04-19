<?php

namespace app\models;

use app\helpers\App;
use app\widgets\Anchor;
use app\widgets\Label;

/**
 * This is the model class for table "{{%notifications}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $message
 * @property string|null $link
 * @property string $type
 * @property string $token
 * @property int $status
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Notification extends ActiveRecord
{
    const STATUS_READ = 1;
    const STATUS_UNREAD = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%notifications}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'notification',
            'mainAttribute' => 'message',
            'paramName' => 'token',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return $this->setRules([
            [['user_id', 'status',], 'integer'],
            [['message', 'link'], 'string'],
            [['type', 'user_id'], 'required'],
            [['type'], 'string', 'max' => 128],
            [['user_id'], 'exist', 'targetRelation' => 'user'],
            ['status', 'in', 'range' => [self::STATUS_READ, self::STATUS_UNREAD]],
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
            'message' => 'Message',
            'link' => 'Link',
            'type' => 'Type',
            'status' => 'Status',
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\NotificationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\NotificationQuery(get_called_class());
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function gridColumns()
    {
        return [
            'message' => [
                'attribute' => 'message',
                'format' => 'raw',
                'value' => function ($model) {
                    return Anchor::widget([
                        'title' => $model->message,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'link' => [
                'attribute' => 'id',
                'value' => 'statusHtml',
                'label' => 'Status',
                'format' => 'raw'
            ],
            // 'type' => ['attribute' => 'type', 'format' => 'raw'],
            // 'token' => ['attribute' => 'token', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            'message:raw',
            'statusHtml' => [
                'label' => 'status',
                'attribute' => 'statusHtml',
                'format' => 'raw'
            ],
        ];
    }

    public function getFooterDetailColumns()
    {
        $col = parent::getFooterDetailColumns();
        unset($col['recordStatusHtml']);

        return $col;
    }

    public function getStatusData()
    {
        return App::params('notification_status')[$this->status];
    }

    public function getStatusHtml()
    {
        return Label::widget([
            'options' => $this->statusData
        ]);
    }

    public function getIsNew()
    {
        return $this->status == 1;
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->message = $this->message ?: App::setting('notification')->{$this->type};

        return true;
    }

    public function setToRead()
    {
        $this->status = self::STATUS_READ;
    }

    public function setToUnread()
    {
        $this->status = self::STATUS_UNREAD;
    }

    public function getBulkActions()
    {
        $bulkActions = parent::getBulkActions();

        $bulkActions['read'] = [
            'label' => 'Read',
            'process' => 'read',
            'icon' => 'read',
            'function' => function ($id) {
                self::readAll(['id' => $id]);
            }
        ];
        $bulkActions['unread'] = [
            'label' => 'Un-Read',
            'process' => 'unread',
            'icon' => 'in_active',
            'function' => function ($id) {
                self::unreadAll(['id' => $id]);
            }
        ];

        return $bulkActions;
    }

    public static function activeAll($condition = '')
    {
        $condition['user_id'] = $condition['user_id'] ?? App::identity('id');
        return parent::activeAll($condition);
    }

    public static function inactiveAll($condition = '')
    {
        $condition['user_id'] = $condition['user_id'] ?? App::identity('id');
        return parent::inactiveAll($condition);
    }

    public static function deleteAll($condition = null, $params = [])
    {
        $condition['user_id'] = $condition['user_id'] ?? App::identity('id');
        return parent::deleteAll($condition, $params);
    }

    public static function readAll($condition = '')
    {
        $condition['user_id'] = $condition['user_id'] ?? App::identity('id');
        return parent::updateAll(['status' => self::STATUS_READ], $condition);
    }

    public static function unreadAll($condition = '')
    {
        $condition['user_id'] = $condition['user_id'] ?? App::identity('id');
        return parent::updateAll(['status' => self::STATUS_UNREAD], $condition);
    }

    public static function unread($user_id = '')
    {
        $user_id = $user_id ?: App::identity('id');
        return self::find()
            ->where(['user_id' => $user_id])
            ->unread()
            ->all();
    }

    public static function totalUnread($user_id = '')
    {
        $user_id = $user_id ?: App::identity('id');
        return self::find()
            ->where(['user_id' => $user_id])
            ->unread()
            ->count();
    }

    public function getLabel()
    {
        $data = App::keyMapParams('notification_types', 'type', 'label');
        return $data[$this->type];
    }
}