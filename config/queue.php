<?php
return [
    'class' => \yii\queue\db\Queue::class,
    'db' => 'db', // DB connection component or its config 
    'tableName' => '{{%queues}}', // Table name
    'channel' => 'default', // Queue channel key
    'mutex' => \yii\mutex\MysqlMutex::class, // Mutex that used to sync queries
    'as log' => \yii\queue\LogBehavior::class,
    'ttr' => 5 * 60, // Max time for job execution
    'attempts' => 3, // Max number of attempts
];