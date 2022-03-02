<?php

namespace app\components;

class MigrateControllerComponent extends \yii\console\controllers\MigrateController
{
    public $migrationTable = '{{%migrations}}';
    public $generatorTemplateFiles = [
        'create_table'    => '@app/migrations/templates/createTableMigration.php',
        'drop_table'      => '@app/migrations/templates/dropTableMigration.php',
        'add_column'      => '@app/migrations/templates/addColumnMigration.php',
        'drop_column'     => '@app/migrations/templates/dropColumnMigration.php',
        'create_junction' => '@app/migrations/templates/createTableMigration.php'
    ];
}