<?php

namespace app\models;

use Yii;
use app\helpers\App;
use app\widgets\Anchor;

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
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%queues}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'queue',
            'mainAttribute' => 'pushed_at',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return $this->setRules([
            [['channel', 'pushed_at', 'ttr'], 'required'],
            [['job'], 'string'],
            [['pushed_at', 'ttr', 'delay', 'priority', 'reserved_at', 'attempt', 'done_at',], 'integer'],
            [['channel'], 'string', 'max' => 255],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->setAttributeLabels([
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
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\QueueQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\QueueQuery(get_called_class());
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

    public static function push($job)
    {
        App::queue()->push($job);
    }

    /**
    public function getExportColumns()
    {
        return [];
    }
    */
}