<?php

namespace app\models;

use Yii;
use app\helpers\App;
use app\models\search\SettingSearch;
use app\widgets\Anchor;
use yii\behaviors\SluggableBehavior;
use yii\helpers\Url;

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
class Session extends MainModel
{
    public $arrayAttr = [];
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
        return '{{%sessions}}';
    }

    public function getMainAttribute()
    {
        return $this->browser;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ip', 'browser', 'os', 'device'], 'required'],
            [['expire', 'user_id', 'record_status', 'created_by', 'updated_by'], 'integer'],
            [['data'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['id'], 'string', 'max' => 40],
            [['ip'], 'string', 'max' => 32],
            [['browser', 'os', 'device'], 'string', 'max' => 128],
            [['id'], 'unique'],
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

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'expire' => 'Expire',
            'data' => 'Data',
            'user_id' => 'User ID',
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



    public function tableColumns()
    {
        return [
            'serial' => [
                'class' => 'yii\grid\SerialColumn',
            ],
            'checkbox' => ['class' => 'app\widgets\CheckboxColumn'],
            'id' => [
                'attribute' => 'id', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->id,
                        'link' => ['view', 'id' => $model->id],
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
                            'link' => ['user/view', 'id' => $model->user_id],
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
            'expire:raw',
            'data:raw',
            'user_id:raw',
            'ip:raw',
            'browser:raw',
            'os:raw',
            'device:raw',
			'created_at:fulldate',
            'updated_at:fulldate',
            'createdByEmail',
            'updatedByEmail',
            'recordStatusHtml:raw'
        ];
    }
    
}
