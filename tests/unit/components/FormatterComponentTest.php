<?php

namespace tests\unit\components;

class FormatterComponentTest extends \Codeception\Test\Unit
{
    public $formatter;

    public function _before()
    {
        $this->formatter = \Yii::$app->formatter;
    }

    public function testAsStripTags()
    {
        expect($this->formatter->asStripTags('<p>Hello</p>'))->equals('Hello');
    }

    public function testAsAgo()
    {
        expect($this->formatter->asAgo('now'))->equals('Just now');
    }

    public function testAsDateToTimezone()
    {
        $this->tester->assertStringContainsString('January 20, 1994',
            $this->formatter->asDateToTimezone(
                date('Y-m-d', strtotime('01/20/1994'))
            )
        );
    }

    public function testAsController2Menu()
    {
        expect($this->formatter->asController2Menu('UserController'))->equals('User');
    }

    public function testAsBoolString()
    {
        expect($this->formatter->asBoolString(true))->equals('True');
        expect($this->formatter->asBoolString(false))->equals('False');
    }

    public function testAsEncode()
    {
        expect($this->formatter->asEncode(['test' => 'value']))->equals('{"test":"value"}');
    }

    public function testAsDecode()
    {
        expect($this->formatter->asDecode('{"test":"value"}'))
            ->equals(['test' => 'value']);
    }

    public function testAsJsonEditor()
    {
        $this->tester->assertStringContainsString(
            '<div id="',
            $this->formatter->asJsonEditor(['test' => 'value'])
        );
    }

    public function testAsQuery2ControllerID()
    {
        expect($this->formatter->asQuery2ControllerID('ModelFIleQuery'))->equals('model-file');
        expect($this->formatter->asQuery2ControllerID('UserQuery'))->equals('user');
    }

    public function testAsFileSize()
    {
        expect($this->formatter->asFileSize(1073741824))->equals('1.00 GB');
        expect($this->formatter->asFileSize(1048576))->equals('1.00 MB');
        expect($this->formatter->asFileSize(1024))->equals('1.00 KB');
        expect($this->formatter->asFileSize(1))->equals('1 byte');
        expect($this->formatter->asFileSize(2))->equals('2 bytes');
        expect($this->formatter->asFileSize(0))->equals('0 bytes');
    }
}