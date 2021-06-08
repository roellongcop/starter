<?php

namespace tests\unit\models;

use app\helpers\App;
use app\models\form\ContactForm;
use yii\mail\MessageInterface;

class PasswordResetFormTest extends \Codeception\Test\Unit
{
    private $model;
    /**
     * @var \UnitTester
     */
    public $tester;

    public function testEmailIsSentOnContact()
    {
        $this->model = $this->getMockBuilder('app\models\form\PasswordResetForm')
            ->setMethods(['validate'])
            ->getMock();

        $this->model->expects($this->once())
            ->method('validate')
            ->willReturn(true);

        $this->model->attributes = [
            'email' => 'developer@developer.com',
        ];

        expect_that($this->model->process());

        // using Yii2 module actions to check email was sent
        $this->tester->seeEmailIsSent();

        /** @var MessageInterface $emailMessage */
        $emailMessage = $this->tester->grabLastSentEmail();
        expect('valid email is sent', $emailMessage)->isInstanceOf('yii\mail\MessageInterface');
        expect($emailMessage->getTo())->hasKey('developer@developer.com');
    }

    public function testNotExistUserDontEmailed()
    {
        $this->model = $this->getMockBuilder('app\models\form\PasswordResetForm')
            ->setMethods(['validate'])
            ->getMock();

        $this->model->expects($this->once())
            ->method('validate')
            ->willReturn(true);

        $this->model->attributes = [
            'email' => 'admin@admins.com',
        ];

        expect_not($this->model->process());
    }

    public function testPasswordHintIsChecked()
    {
        $this->model = $this->getMockBuilder('app\models\form\PasswordResetForm')
            ->setMethods(['validate'])
            ->getMock();

        $this->model->expects($this->once())
            ->method('validate')
            ->willReturn(true);

        $this->model->attributes = [
            'email' => 'admin@admins.com',
            'hint' => true
        ];

        expect($this->model->process());
    }
}
