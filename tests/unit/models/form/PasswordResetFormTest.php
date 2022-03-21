<?php

namespace tests\unit\models\form;

use app\helpers\App;
use app\models\form\PasswordResetForm;
use yii\mail\MessageInterface;

class PasswordResetFormTest extends \Codeception\Test\Unit
{
    public function testEmailIsSentOnContact()
    {
        $model = new PasswordResetForm([
            'email' => 'developer@developer.com',
        ]);

        expect_that($model->process());

        // using Yii2 module actions to check email was sent
        $this->tester->seeEmailIsSent();

        /** @var MessageInterface $emailMessage */
        $emailMessage = $this->tester->grabLastSentEmail();
        expect('valid email is sent', $emailMessage)->isInstanceOf('yii\mail\MessageInterface');
        expect($emailMessage->getTo())->hasKey('developer@developer.com');
    }

    public function testNotExistUserDontEmailed()
    {
        $model = new PasswordResetForm([
            'email' => 'admin@admins.com',
        ]);

        expect_not($model->process());
    }

    public function testPasswordHintIsChecked()
    {
        $model = new PasswordResetForm([
            'email' => 'admin@admins.com',
            'hint' => true
        ]);

        expect($model->process());
    }
}