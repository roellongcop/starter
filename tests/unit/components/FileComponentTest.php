<?php

namespace tests\unit\components;

class FileComponentTest extends \Codeception\Test\Unit
{
    public $file;

    public function _before()
    {
        $this->file = \Yii::$app->file;
    }

    public function testCreateIndexFile()
    {
        $folders = ['test'];
        $this->file->createDirectory([\Yii::getAlias('@consoleWebroot'), 'test']);
        $this->file->createIndexFile($folders);

        $this->tester->assertFileExists(\Yii::getAlias('@consoleWebroot') . '/test/index.php');
        $this->tester->assertFileExists(\Yii::getAlias('@consoleWebroot') . '/test/.htaccess');
    }
}