<?php

namespace app\components;

class ConnectionComponent extends \yii\db\Connection
{
    /* Main Connection (Laragon configuration)
    public $dsn = 'mysql:host=localhost;dbname=db_starter';
    public $username = 'root';
    public $password = '';
    public $charset = 'utf8';
    public $tablePrefix = 'tbl_';
    */

    // Docker configuration for MariaDB connection
    public $dsn = 'mysql:host=mariadb;port=3306;dbname=db_starter';
    public $username = 'root';
    public $password = 'root_password';
    public $charset = 'utf8';
    public $tablePrefix = 'tbl_';

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
    
}
