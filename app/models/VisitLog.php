<?php

namespace app\models;

use Yii;
use app\helpers\App;
use app\widgets\Anchor;
use app\models\query\VisitLogQuery;

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
    public $relatedModels = [];
    //public $excel_ignore_attr = [];
    //public $fileInput;
    // public $imageInput;
    //public $fileLocation; 

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%visit_logs}}';
    }

    public function getMainAttribute()
    {
        return $this->actionLabel;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'action', 'record_status', 'created_by', 'updated_by'], 'integer'],
            [['record_status'], 'default', 'value' => 1],
            [['user_id'], 'default', 'value' => 0],
            [['ip', 'action', 'record_status'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['ip'], 'string', 'max' => 255],
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
            'user_id' => 'Username',
            'ip' => 'Ip',
            'action' => 'Action',
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
     * @return \app\models\query\VisitLogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VisitLogQuery(get_called_class());
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
        return App::params('visit_logs_action')[$this->action];
    }

    public function getTableColumns()
    {
        return [
            'serial' => [
                'class' => 'yii\grid\SerialColumn',
            ],
            'checkbox' => ['class' => 'app\widgets\CheckboxColumn'],
            'username' => [
                'attribute' => 'username', 
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
            'action' => [
                'attribute' => 'action', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->actionLabel,
                        'link' => ['visit-log/view', 'id' => $model->id],
                        'text' => true
                    ]);
                }
            ],
            'ip' => ['attribute' => 'ip', 'format' => 'raw'],
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

    public function getActionLabel()
    {
        return $this->visitLogsAction['label'];
    }

    public function getDetailColumns()
    {
        return [
            'userName:raw',
            'ip:raw',
            'actionLabel:raw',
			'created_at:fulldate',
            'updated_at:fulldate',
            'createdByEmail',
            'updatedByEmail',
            'recordStatusHtml:raw'
        ];
    }


    public static function log($action=0)
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
        return self::log(1);
    }

}
