<?php

namespace app\models;

use Yii;
use app\helpers\App;
use app\widgets\Anchor;
use app\widgets\JsonEditor;
use yii\helpers\Inflector;
use yii\helpers\Url;

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
    public $relatedModels = [];
    public $_username;
    //public $excel_ignore_attr = [];
    //public $fileInput;
    // public $imageInput;
    //public $fileLocation; 

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%logs}}';
    }

    public function controllerID()
    {
        return 'log';
    }

    public function mainAttribute()
    {
        return 'action';
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
            [['user_id', 'model_id', 'record_status', 'created_by', 'updated_by'], 'integer'],
            [['record_status'], 'default', 'value' => 1],
            ['record_status', 'in', 'range' => [parent::RECORD_ACTIVE, parent::RECORD_INACTIVE]],
            [['user_id', 'model_id'], 'default', 'value' => 0],
            [[ 'url'], 'string'],
            [['request_data', 'change_attribute', 'server'], 'safe'],
            [['method', 'action', 'controller', 'table_name', 'model_name', 'ip', 'browser', 'os', 'device', 'record_status'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['method', 'ip'], 'string', 'max' => 32],
            [['action', 'controller', 'table_name', 'model_name'], 'string', 'max' => 256],
            [['browser', 'os', 'device'], 'string', 'max' => 128],
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
            ],*/

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
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
     * @return \app\models\query\LogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\LogQuery(get_called_class());
    }
     

    public function afterFind()
    {
        parent::afterFind();
        $this->table_name = App::db('tablePrefix') . $this->table_name;
    }
   

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getUsername()
    {
        if ($this->_username) {
            return $this->_username;
        }

        if(($user = $this->user) != null) {
            $this->_username = $user->username;
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
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->username,
                        'link' => $model->user->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            // 'model_id' => ['attribute' => 'model_id', 'format' => 'raw'],
            // 'request_data' => ['attribute' => 'request_data', 'format' => 'raw'],
            // 'change_attribute' => ['attribute' => 'change_attribute', 'format' => 'raw'],

            'action' => [
                'attribute' => 'action', 
                'label' => 'Action',
                'format' => 'raw',
                'value' => function($model) {
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
                'title' => Url::to($url, true),
                'link' => $url,
                'text' => true
            ]);

        }
        return 'No Preview';
    }

    public function getModelInstance()
    {
        $class = Yii::createObject("\\app\\models\\{$this->model_name}");
        
        return $this->hasOne($class::className(), ['id' => 'model_id']);
    }

    public function detailColumns()
    {
        return [
            [
                'attribute' => 'user_id', 
                'label' => 'Username',
                'format' => 'raw',
                'value' => function($model) {
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


    public static function record($model, $changedAttributes=[])
    {
        if (App::isLogin() && App::getModelName($model) != 'Log') {
            $log                   = new self();
            $log->request_data     = App::getBodyParams();
            $log->method           = App::getMethod();
            $log->url              = App::absoluteUrl();
            $log->user_id          = App::identity('id');
            $log->model_id         = $model->id ?: 0;
            $log->action           = App::actionID();
            $log->controller       = App::controllerID();
            $log->table_name       = App::tableName($model, false);
            $log->model_name       = App::getModelName($model);
            $log->server           = App::server();
            $log->ip               = App::ip();
            $log->browser          = App::browser();
            $log->os               = App::os();
            $log->device           = App::device();
            $log->change_attribute = $changedAttributes;

            if ($log->save()) {
                return true;
            }
            App::danger($log->errors);
        }
    }
}
