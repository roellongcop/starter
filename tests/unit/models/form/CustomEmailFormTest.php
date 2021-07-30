<?php
namespace tests\unit\models\form;

use app\helpers\App;
use app\models\form\CustomEmailForm;
use yii\mail\MessageInterface;

class CustomEmailFormTest extends \Codeception\Test\Unit
{
  
    private function data($replace=[])
    {
        return array_replace([
            'to' => 'to@domain.com',
            'subject' => 'Subject',
            'cc' => ['cc1@domain.com', 'cc2@domain.com'],
            'bcc' => ['bcc1@domain.com', 'bcc2@domain.com'],
            'content' => 'Content',
            'from' => 'from@domain.com',
            'sender_name' => 'Sender Name',
            'template' => '',
            'parameters' => '',
        ], $replace);
    }

    public function testRequiredFields()
    {
        $data = $this->data();
        $data['to'] = '';
        $model = new CustomEmailForm($data);
        expect_not($model->send());
        expect($model->errors)->hasKey('to');

        $data = $this->data();
        $data['subject'] = '';
        $model = new CustomEmailForm($data);
        expect_not($model->send());
        expect($model->errors)->hasKey('subject');
    }

    public function testSentSuccess()
    {
        $model = new CustomEmailForm($this->data());

        expect_that($model->send());

        // using Yii2 module actions to check email was sent
        $this->tester->seeEmailIsSent();

        /** @var MessageInterface $emailMessage */
        $emailMessage = $this->tester->grabLastSentEmail();
        expect('valid email is sent', $emailMessage)->isInstanceOf('yii\mail\MessageInterface');
        expect($emailMessage->getTo())->hasKey('to@domain.com');
        expect($emailMessage->getFrom())->hasKey('from@domain.com');
        expect($emailMessage->getSubject())->equals('Subject');
        expect($emailMessage->toString())->stringContainsString('Content');
    } 

    public function testSentSuccessMultiple()
    {
        $messages = [];
        for ($i=0; $i < 3; $i++) { 
            $model = new CustomEmailForm($this->data());
            $messages[] = $model->send('multiple');
        }
        expect_that(\Yii::$app->mailer->sendMultiple($messages));

        // using Yii2 module actions to check email was sent
        $this->tester->seeEmailIsSent();

        /** @var MessageInterface $emailMessage */
        $emailMessage = $this->tester->grabLastSentEmail();
        expect('valid email is sent', $emailMessage)->isInstanceOf('yii\mail\MessageInterface');
        expect($emailMessage->getTo())->hasKey('to@domain.com');
        expect($emailMessage->getFrom())->hasKey('from@domain.com');
        expect($emailMessage->getSubject())->equals('Subject');
        expect($emailMessage->toString())->stringContainsString('Content');
    }


    public function testSentSuccessWithTemplate()
    {
        $model = new CustomEmailForm($this->data([
            'template' => 'password_reset',
            'parameters' => [
                'user' => $this->tester->grabRecord('app\models\User', ['username' => 'developer'])
            ]
        ]));

        expect_that($model->send());

        // using Yii2 module actions to check email was sent
        $this->tester->seeEmailIsSent();

        /** @var MessageInterface $emailMessage */
        $emailMessage = $this->tester->grabLastSentEmail();
        expect('valid email is sent', $emailMessage)->isInstanceOf('yii\mail\MessageInterface');
        expect($emailMessage->getTo())->hasKey('to@domain.com');
        expect($emailMessage->getFrom())->hasKey('from@domain.com');
        expect($emailMessage->getSubject())->equals('Subject');
        expect($emailMessage->toString())->stringContainsString('Content');
    } 

    public function testSentSuccessWithTemplateMultiple()
    {
        $messages = [];
        for ($i=0; $i < 3; $i++) { 
            $model = new CustomEmailForm($this->data([
                'template' => 'password_reset',
                'parameters' => [
                    'user' => $this->tester->grabRecord('app\models\User', ['username' => 'developer'])
                ]
            ]));
            $messages[] = $model->send('multiple');
        }
        expect_that(\Yii::$app->mailer->sendMultiple($messages));

        // using Yii2 module actions to check email was sent
        $this->tester->seeEmailIsSent();

        /** @var MessageInterface $emailMessage */
        $emailMessage = $this->tester->grabLastSentEmail();
        expect('valid email is sent', $emailMessage)->isInstanceOf('yii\mail\MessageInterface');
        expect($emailMessage->getTo())->hasKey('to@domain.com');
        expect($emailMessage->getFrom())->hasKey('from@domain.com');
        expect($emailMessage->getSubject())->equals('Subject');
        expect($emailMessage->toString())->stringContainsString('Content');
    }
}