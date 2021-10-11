<?php

namespace tests\unit\models\form;

use app\models\File;
use app\models\form\UploadForm;

class UploadFormTest extends \Codeception\Test\Unit
{
    public function testUploadImageSuccess()
    {
        $folders = [
            \Yii::getAlias('@consoleWebroot'),
            'protected',
            'uploads',
            date('Y'),
            date('m')
        ];

        $model = new UploadForm(['modelName' => 'User']);

        $model->fileInput = new \yii\web\UploadedFile([
            'name' => 'image-png.png',
            'tempName' => codecept_data_dir() . 'image-png.png',
            'type' => 'image/png',
            'size' => 11400,
            'error' => 0
        ]);

        expect_that($model->validate());
        expect_that($model->upload());

        $this->tester->grabRecord('app\models\File', [
            'name' => 'image-png.png',
            'extension' => 'png'
        ]);

        $index = $folders;
        $index[] = 'index.php';
        $path = implode('/', $index);
        $this->tester->assertFileExists($path);

        $htaccess = $folders;
        $htaccess[] = '.htaccess';
        $path = implode('/', $htaccess);
        $this->tester->assertFileExists($path);
    }

    public function testInvalidExtension()
    {
        $model = new UploadForm([
            'modelName' => 'User',
            'extensions' => File::EXTENSIONS['file']
        ]);

        $model->fileInput = new \yii\web\UploadedFile([
            'name' => 'image-png.png',
            'tempName' => codecept_data_dir() . 'image-png.png',
            'type' => 'image/png',
            'size' => 11400,
            'error' => 0
        ]);

        expect_not($model->validate());
        expect_not($model->upload());
        expect($model->errors)->hasKey('fileInput');
    }

    public function testUploadSqlSuccess()
    {
        $folders = [
            \Yii::getAlias('@consoleWebroot'),
            'protected',
            'uploads',
            date('Y'),
            date('m')
        ];

        $model = new UploadForm(['modelName' => 'User']);

        $model->fileInput = new \yii\web\UploadedFile([
            'name' => 'test-sql.sql',
            'tempName' => codecept_data_dir() . 'test-sql.sql',
            'type' => 'image/png',
            'size' => 11400,
            'error' => 0
        ]);

        expect_that($model->validate());
        expect_that($model->upload());

        $this->tester->grabRecord('app\models\File', [
            'name' => 'test-sql.sql',
            'extension' => 'sql'
        ]);

        $index = $folders;
        $index[] = 'index.php';
        $path = implode('/', $index);
        $this->tester->assertFileExists($path);

        $htaccess = $folders;
        $htaccess[] = '.htaccess';
        $path = implode('/', $htaccess);
        $this->tester->assertFileExists($path);
    }

    public function testCreateIndexFile()
    {
        $model = new UploadForm();
        $folders = ['protected/test'];
        $model->createDirectory($folders);
        $model->createIndexFile($folders);
        $this->tester->assertFileExists(\Yii::getAlias('@consoleWebroot') . '/protected/test/index.php');
        $this->tester->assertFileExists(\Yii::getAlias('@consoleWebroot') . '/protected/test/.htaccess');
    }
}