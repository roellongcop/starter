<?php
namespace tests\unit\models;

use app\models\Backup;
use yii\helpers\Inflector;

class BackupTest extends \Codeception\Test\Unit
{
    public function testCreate()
    {
        $dbPref = \Yii::$app->db->tablePrefix;

        $model = new Backup([
            'filename' => (string) time(),
            'tables' => [
               "{$dbPref}backups" => "{$dbPref}backups",
               "{$dbPref}files" => "{$dbPref}files",
               "{$dbPref}ips" => "{$dbPref}ips",
               "{$dbPref}logs" => "{$dbPref}logs",
               "{$dbPref}migrations" => "{$dbPref}migrations",
               "{$dbPref}model_files" => "{$dbPref}model_files",
               "{$dbPref}notifications" => "{$dbPref}notifications",
               "{$dbPref}queues" => "{$dbPref}queues",
               "{$dbPref}roles" => "{$dbPref}roles",
               "{$dbPref}sessions" => "{$dbPref}sessions",
               "{$dbPref}settings" => "{$dbPref}settings",
               "{$dbPref}themes" => "{$dbPref}themes",
               "{$dbPref}user_metas" => "{$dbPref}user_metas",
               "{$dbPref}users" => "{$dbPref}users",
               "{$dbPref}visit_logs" => "{$dbPref}visit_logs",
            ],
            'description' => 'Description',
            'record_status' => 1,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        $model->validate();

        expect_that($model->save());
    }

    public function testCreateNoData()
    {
        $model = new Backup([
            'record_status' => 1,  
        ]);

        expect_not($model->save());
    }

    public function testCreateNoTables()
    {
        $model = new Backup([
            'filename' => (string) time(),
            'description' => 'Description',
            'record_status' => 1,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        $model->validate();

        expect_that($model->save());
    }

    public function testCreateNoFilename()
    {
        $time = time();
        $dbPref = \Yii::$app->db->tablePrefix;

        $model = new Backup([
            'tables' => [
               "{$dbPref}backups" => "{$dbPref}backups",
               "{$dbPref}files" => "{$dbPref}files",
               "{$dbPref}ips" => "{$dbPref}ips",
               "{$dbPref}logs" => "{$dbPref}logs",
               "{$dbPref}migrations" => "{$dbPref}migrations",
               "{$dbPref}model_files" => "{$dbPref}model_files",
               "{$dbPref}notifications" => "{$dbPref}notifications",
               "{$dbPref}queues" => "{$dbPref}queues",
               "{$dbPref}roles" => "{$dbPref}roles",
               "{$dbPref}sessions" => "{$dbPref}sessions",
               "{$dbPref}settings" => "{$dbPref}settings",
               "{$dbPref}themes" => "{$dbPref}themes",
               "{$dbPref}user_metas" => "{$dbPref}user_metas",
               "{$dbPref}users" => "{$dbPref}users",
               "{$dbPref}visit_logs" => "{$dbPref}visit_logs",
            ],
            'description' => 'Description',
            'record_status' => 1,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        expect_not($model->save());
        expect($model->errors)->hasKey('filename');
    }
}