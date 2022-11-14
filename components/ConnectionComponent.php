<?php

namespace app\components;

class ConnectionComponent extends \yii\db\Connection
{
    public $dsn = 'mysql:host=localhost;dbname=db_starter';
    public $username = 'root';
    public $password = '';
    public $charset = 'utf8';
    public $tablePrefix = 'tbl_';

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
}