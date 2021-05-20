<?php
use app\helpers\App;
use yii\db\Expression;

return [
    'class' => 'yii\web\DbSession',
    'sessionTable' => '{{%sessions}}',
    // 'timeout' => 1440,
    'writeCallback' => function ($session) { 
        return [
            'user_id' => App::user('id'),
            'ip' => App::ip(),
            'browser' => App::browser(),
            'os' => App::os(),
            'device' => App::device(),
            'created_at' => new Expression('UTC_TIMESTAMP'),
            'updated_at' => new Expression('UTC_TIMESTAMP'),
       ];
    }
];