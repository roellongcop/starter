<?php
use app\models\Ip;
use yii\helpers\Inflector;

return [
    'whitelist' => [
        'name' => '191.168.1.1', 
        'description' => 'testing whitelist IP',
        'type' => Ip::TYPE_WHITELIST,
        'slug' => Inflector::slug('191.168.1.1'),
        'created_by' => 1,
        'updated_by' => 1,
    ],
    'blacklist' => [
        'name' => '191.168.1.2', 
        'description' => 'testing blacklist IP',
        'type' => Ip::TYPE_BLACKLIST,
        'slug' => Inflector::slug('191.168.1.2'),
        'created_by' => 1,
        'updated_by' => 1,
    ],
];