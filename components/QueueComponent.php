<?php

namespace app\components;

use app\models\Queue;

class QueueComponent extends \yii\queue\db\Queue
{
    public $db = 'db'; // DB connection component or its config 
    public $tableName = '{{%queues}}'; // Table name
    public $channel = 'default'; // Queue channel key
    public $mutex = 'yii\mutex\MysqlMutex'; // Mutex that used to sync queries
    public $ttr = 5 * 60; // Max time for job execution
    public $attempts = 3; // Max number of attempts
}