<?php

namespace tests\unit\jobs;

use app\jobs\BackupJob;

class BackupJobTest extends \Codeception\Test\Unit
{
    public function testExecute()
    {
        $model = new BackupJob([
            'backupId' => 1
        ]);

        $model->execute(1);

        $folders = [
            \Yii::getAlias('@consoleWebroot'),
            'protected',
            'backups',
            date('Y'),
            date('m'),
        ];

        expect_that(file_exists(implode('/', $folders)));

        $file = $this->tester->grabRecord('app\models\File', [
            'name' => 'first-backup',
            'extension' => 'sql'
        ]);

        expect_that($file);

        $this->tester->seeRecord('app\models\ModelFile', [
            'file_id' => $file->id,
            'model_id' => 1,
            'extension' => 'sql',
            'model_name' => 'Backup',
        ]);
    }
}