<?php

namespace tests\unit\models;

use app\models\Backup;
use yii\helpers\Inflector;

class BackupTest extends \Codeception\Test\Unit
{
    protected function data($replace = [])
    {
        $dbPref = \Yii::$app->db->tablePrefix;
        return array_replace([
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
            'record_status' => Backup::RECORD_ACTIVE
        ], $replace);
    }

    public function testCreateSuccess()
    {
        $model = new Backup($this->data());
        expect_that($model->save());
    }

    public function testNoInactiveDataAccessRoleUserCreateInactiveData()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', [
            'username' => 'no_inactive_data_access_role_user'
        ]));

        $data = $this->data(['record_status' => Backup::RECORD_INACTIVE]);

        $model = new Backup($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');

        \Yii::$app->user->logout();
    }

    public function testCreateInvalidRecordStatus()
    {
        $data = $this->data(['record_status' => 3]);

        $model = new Backup($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }

    public function testCreateNoData()
    {
        $model = new Backup();
        expect_not($model->save());
    }

    public function testCreateNoTables()
    {
        $data = $this->data();
        unset($data['tables']);
        $model = new Backup($data);
        expect_that($model->save());
    }

    public function testCreateExistingFilename()
    {
        $data = $this->data(['filename' => 'first-backup']);
        $model = new Backup($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('filename');
    }

    public function testCreateNoFilename()
    {
        $data = $this->data();
        unset($data['filename']);
        $model = new Backup($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('filename');
    }

    public function testActivateData()
    {
        $model = $this->tester->grabRecord('app\models\Backup');
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateData()
    {
        $model = $this->tester->grabRecord('app\models\Backup');
        expect_that($model);

        $model->inactivate();
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }

    public function testDownload()
    {
        $model = $this->tester->grabRecord('app\models\Backup');
        expect_that($model->download());
    }

    public function testRestore()
    {
        $model = $this->tester->grabRecord('app\models\Backup');
        expect_that($model->restore());
    }
}