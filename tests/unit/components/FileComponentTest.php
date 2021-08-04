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
        $folders = ['protected/test'];
        $this->file->createDirectory($folders);
        $this->file->createIndexFile($folders);

        $this->tester->assertFileExists(\Yii::getAlias('@consoleWebroot') . '/protected/test/index.php');
        $this->tester->assertFileExists(\Yii::getAlias('@consoleWebroot') . '/protected/test/.htaccess');
    }
}