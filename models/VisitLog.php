<?php

namespace app\models;

use Yii;
use app\helpers\App;
use app\widgets\Anchor;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%visit_logs}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $ip
 * @property int $action
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class VisitLog extends ActiveRecord
{
    const ACTION_LOGIN = 0;
    const ACTION_LOGOUT = 1;

    const ACTIONS = [
        0 => [
            'id' => 0,
            'label' => 'Login',
            'class' => 'success'
        ],
        1 => [
            'id' => 1,
            'label' => 'Logout',
            'class' => 'danger'
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%visit_logs}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'visit-log',
            'mainAttribute' => 'actionLabel',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return $this->setRules([
            [['user_id', 'action',], 'integer'],
            [['user_id'], 'default', 'value' => 0],
            [['ip', 'action',], 'required'],
            [['ip'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'targetRelation' => 'user'],
            [['action'], 'in', 'range' => [self::ACTION_LOGIN, self::ACTION_LOGOUT]],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->setAttributeLabels([
            'id' => 'ID',
            'user_id' => 'Username',
            'ip' => 'Ip',
            'action' => 'Action',
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\VisitLogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\VisitLogQuery(get_called_class());
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

    public function getVisitLogsAction()
    {
        return self::ACTIONS[$this->action];
    }

    public function gridColumns()
    {
        return [
            'username' => [
                'attribute' => 'username', 
                'label' => 'Username',
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->username,
                        'link' => $model->user->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'action' => [
                'attribute' => 'action', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->actionLabel,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'ip' => ['attribute' => 'ip', 'format' => 'raw'],
        ];
    }

    public function getActionLabel()
    {
        return $this->visitLogsAction['label'];
    }

    public function detailColumns()
    {
        return [
            'userName:raw',
            'ip:raw',
            'actionLabel:raw',
        ];
    }

    public static function log($action=self::ACTION_LOGIN)
    {
        $visit = new self();
        $visit->user_id = App::identity('id');
        $visit->ip = App::ip();
        $visit->action = $action; // login | logout
        return $visit->save();
    }

    public static function login()
    {
        return self::log();
    }

    public static function logout()
    {
        return self::log(self::ACTION_LOGOUT);
    }

    public static function users()
    {
        $data = User::find()
            ->innerJoinWith('visitLogs')
            ->all();

        $data = array_values(ArrayHelper::map($data, 'id', 'username'));

        $data = array_unique($data);
        $data = array_values($data);
        
        return $data;
    }
}