<?php

namespace tests\unit\models;

use app\models\Backup;
use yii\helpers\Inflector;

class BackupTest extends \Codeception\Test\Unit
{
    protected function data()
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
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }

    public function testCreateSuccess()
    {
        $model = new Backup($this->data());
        expect_that($model->save());
    }

    public function testCreateInvalidRecordStatusMustFailed()
    {
        $data = $this->data();
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
        $data = $this->data();
        unset($data['tables']);
        $model = new Backup($data);
        expect_that($model->save());
    }

    public function testCreateExistingFilenameMustFailed()
    {
        $data = $this->data();
        $data['filename'] = 'first-backup';
        $model = new Backup($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('filename');
    }

    public function testCreateNoFilenameMustFailed()
    {
        $data = $this->data();
        unset($data['filename']);
        $model = new Backup($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('filename');
    }

    public function testActivateDataMustSuccess()
    {
        $model = Backup::findOne(1);
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateDataMustFailed()
    {
        $model = Backup::findOne(1);
        expect_that($model);

        $model->deactivate();
        expect_not($model->save());
    }

    public function testDownloadMustSuccess()
    {
        $model = Backup::findOne(1);
        expect_that($model->download());
    }

    public function testRestoreMustSuccess()
    {
        $model = Backup::findOne(1);
        expect_that($model->restore());
    }
}