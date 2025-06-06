<?php

namespace app\models;

use Yii;
use app\helpers\App;
use app\widgets\Anchor;
use app\helpers\Url;
use app\models\form\UserAgentForm;

/**
 * This is the model class for table "{{%logs}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $model_id
 * @property string|null $request_data
 * @property string|null $change_attribute
 * @property string $method
 * @property string|null $url
 * @property string $action
 * @property string $controller
 * @property string $table_name
 * @property string $model_name
 * @property string|null $server
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
class Log extends ActiveRecord
{
    public $_username;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%logs}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'log',
            'mainAttribute' => 'action',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return $this->setRules([
            [['user_id',], 'integer'],
            [['user_id', 'model_id'], 'default', 'value' => 0],
            [['url'], 'string'],
            [['request_data', 'change_attribute', 'server', 'ip', 'action', 'controller'], 'safe'],
            [['method', 'table_name', 'model_name', 'browser', 'os', 'device'], 'required'],
            [['method'], 'string', 'max' => 32],
            [['action', 'controller', 'table_name', 'model_name'], 'string', 'max' => 255],
            [['browser', 'os', 'device', 'ip'], 'string', 'max' => 128],
            [
                'user_id',
                'validateUserId',
                'when' => function ($model) {
                    return $model->user_id;
                }
            ],
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
            'username' => 'Username',
            'model_id' => 'Model ',
            'request_data' => 'Request Data',
            'change_attribute' => 'Change Attribute',
            'method' => 'Method',
            'url' => 'Url',
            'action' => 'Action',
            'controller' => 'Controller',
            'table_name' => 'Table Name',
            'model_name' => 'Model Name',
            'server' => 'Server',
            'ip' => 'Ip',
            'browser' => 'Browser',
            'os' => 'Os',
            'device' => 'Device',
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\LogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\LogQuery(get_called_class());
    }

    public function validateUserId($attribute, $params)
    {
        if (($user = User::findOne($this->user_id)) == null) {
            $this->addError($attribute, 'Not existing User');
        }
    }

    public function getTableFullname()
    {
        return App::db('tablePrefix') . $this->table_name;
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getUsername()
    {
        if ($this->_username === null) {
            $this->_username = App::if ($this->user, fn($user) => $user->username);
        }

        return $this->_username;
    }

    public function gridColumns()
    {
        return [
            'username' => [
                'attribute' => 'username',
                'label' => 'Username',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->username) {
                        return Anchor::widget([
                            'title' => $model->username,
                            'link' => $model->user->viewUrl,
                            'text' => true
                        ]);
                    }
                    return 'Guest';
                }
            ],
            // 'model_id' => ['attribute' => 'model_id', 'format' => 'raw'],
            // 'request_data' => ['attribute' => 'request_data', 'format' => 'raw'],
            // 'change_attribute' => ['attribute' => 'change_attribute', 'format' => 'raw'],

            'action' => [
                'attribute' => 'action',
                'label' => 'Action',
                'format' => 'raw',
                'value' => function ($model) {
                    return Anchor::widget([
                        'title' => $model->action,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],

            'controller' => ['attribute' => 'controller', 'format' => 'raw'],

            'method' => ['attribute' => 'method', 'format' => 'raw'],
            'url' => ['attribute' => 'url', 'format' => 'raw'],
            'table_name' => ['attribute' => 'table_name', 'format' => 'raw'],
            'model_name' => ['attribute' => 'model_name', 'format' => 'raw'],
            // 'server' => ['attribute' => 'server', 'format' => 'raw'],
            'ip' => ['attribute' => 'ip', 'format' => 'raw'],
            'browser' => ['attribute' => 'browser', 'format' => 'raw'],
            'os' => ['attribute' => 'os', 'format' => 'raw'],
            'device' => ['attribute' => 'device', 'format' => 'raw'],
        ];
    }

    public function getPreview($anchor = true)
    {
        if (($model = $this->modelInstance) != null) {
            if (isset($model->preview)) {
                return $model->preview;
            }
            $url = $model->viewUrl;
            return Anchor::widget([
                'title' => Url::toRoute($url, true),
                'link' => $url,
                'text' => true
            ]);

        }
        return 'No Preview';
    }

    public function getModelInstance()
    {
        $class = Yii::createObject("\\app\\models\\{$this->model_name}");

        return $this->hasOne($class::classname(), ['id' => 'model_id']);
    }

    public function detailColumns()
    {
        return [
            [
                'attribute' => 'user_id',
                'label' => 'Username',
                'format' => 'raw',
                'value' => function ($model) {
                    return Anchor::widget([
                        'title' => $model->username,
                        'link' => ['user/view', 'id' => $model->user_id],
                        'text' => true
                    ]);
                }
            ],
            /*[
            'attribute' => 'model_id', 
            'label' => 'Model ID',
            ],*/
            'preview:raw',
            'action:raw',
            'request_data:jsonEditor',
            'change_attribute:jsonEditor',
            'method:raw',
            'url:raw',
            'controller:raw',
            'table_name:raw',
            'model_name:raw',
            'server:jsonEditor',
            'ip:raw',
            'browser:raw',
            'os:raw',
            'device:raw',
        ];
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['JsonBehavior']['fields'] = [
            'change_attribute',
            'request_data',
            'server',
        ];

        unset($behaviors['LogBehavior']);
        return $behaviors;
    }

    public static function record($model, $changedAttributes = [])
    {
        // if (App::isLogin()) {
        $userAgent = new UserAgentForm();
        $log = new Log();
        $log->request_data = App::getBodyParams();
        $log->method = App::getMethod() ?: 'console';
        $log->url = App::isWeb() ? App::absoluteUrl() : '';
        $log->user_id = App::identity() ? App::identity('id') : 0;
        $log->model_id = $model->id ?: 0;
        $log->action = App::actionID();
        $log->controller = App::controllerID();
        $log->table_name = App::tableName($model, false);
        $log->model_name = App::getModelName($model);
        $log->server = App::server();
        $log->ip = App::ip();
        $log->browser = $userAgent->browser;
        $log->os = $userAgent->os;
        $log->device = $userAgent->device;
        $log->change_attribute = $changedAttributes;

        if ($log->save()) {
            return true;
        }
        // }
    }
}