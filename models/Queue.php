<?php

namespace app\models;

use Yii;
use app\helpers\App;
use app\widgets\Anchor;
use app\models\query\QueueQuery;


/**
 * This is the model class for table "{{%queues}}".
 *
 * @property int $id
 * @property string $channel
 * @property resource|null $job
 * @property int $pushed_at
 * @property int $ttr
 * @property int $delay
 * @property int $priority
 * @property int|null $reserved_at
 * @property int|null $attempt
 * @property int|null $done_at
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Queue extends ActiveRecord
{
    public $relatedModels = [];
    //public $excel_ignore_attr = [];
    //public $fileInput;
    //public $imageInput;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%queues}}';
    }

    public function controllerID()
    {
        return 'queue';
    }

    public function mainAttribute()
    {
        return 'id';
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
            [['channel', 'pushed_at', 'ttr'], 'required'],
            [['job'], 'string'],
            [['pushed_at', 'ttr', 'delay', 'priority', 'reserved_at', 'attempt', 'done_at', 'record_status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['channel'], 'string', 'max' => 255],
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
            [['record_status'], 'required'],
            [['record_status'], 'default', 'value' => 1],
            ['record_status', 'in', 'range' => [parent::RECORD_ACTIVE, parent::RECORD_INACTIVE]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'channel' => 'Channel',
            'job' => 'Job',
            'pushed_at' => 'Pushed At',
            'ttr' => 'Ttr',
            'delay' => 'Delay',
            'priority' => 'Priority',
            'reserved_at' => 'Reserved At',
            'attempt' => 'Attempt',
            'done_at' => 'Done At',
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
     * @return \app\models\query\QueueQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new QueueQuery(get_called_class());
    }
     
     

    public function gridColumns()
    {
        return [
            'channel' => [
                'attribute' => 'channel', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->channel,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'job' => ['attribute' => 'job', 'format' => 'raw'],
            'pushed_at' => ['attribute' => 'pushed_at', 'format' => 'raw'],
            'ttr' => ['attribute' => 'ttr', 'format' => 'raw'],
            'delay' => ['attribute' => 'delay', 'format' => 'raw'],
            'priority' => ['attribute' => 'priority', 'format' => 'raw'],
            'reserved_at' => ['attribute' => 'reserved_at', 'format' => 'raw'],
            'attempt' => ['attribute' => 'attempt', 'format' => 'raw'],
            'done_at' => ['attribute' => 'done_at', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            'channel:raw',
            'job:raw',
            'pushed_at:raw',
            'ttr:raw',
            'delay:raw',
            'priority:raw',
            'reserved_at:raw',
            'attempt:raw',
            'done_at:raw',
        ];
    }

    /**
    public function getExportColumns()
    {
        return [];
    }
    */
}
