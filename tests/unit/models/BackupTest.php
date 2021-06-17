<?php
namespace tests\unit\models;

use app\models\Backup;
use yii\helpers\Inflector;

class BackupTest extends \Codeception\Test\Unit
{
    protected function validData()
    {
        $dbPref = \Yii::$app->db->tablePrefix;
        return [
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
        ];
    }

    public function testCreateSuccess()
    {
        $model = new Backup($this->validData());
        expect_that($model->save());
    }

    public function testCreateInvalidRecordStatusMustFailed()
    {
        $data = $this->validData();
        $data['record_status'] = 3;

        $model = new Backup($data);
        expect_not($model->save());
    }

    public function testCreateNoDataMustFailed()
    {
        $model = new Backup();
        expect_not($model->save());
    }

    public function testCreateNoTablesMustSuccess()
    {
        $data = $this->validData();
        unset($data['tables']);
        $model = new Backup($data);
        expect_that($model->save());
    }

    public function testCreateNoFilenameMustFailed()
    {
        $data = $this->validData();
        unset($data['filename']);
        $model = new Backup($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('filename');
    }

    public function testActivateDataMustSuccess()
    {
        $model = Backup::findOne(1);
        expect_that($model);

        $model->setActive();

        expect_that($model->save());
    }
}