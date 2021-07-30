<?php

namespace tests\unit\jobs;

use app\jobs\EmailJob;

class EmailJobTest extends \Codeception\Test\Unit
{
    public function testExecute()
    {
        $model = new EmailJob([
            'to' => 'to@domain.com',
            'subject' => 'Subject',
            'cc' => 'cc@domain.com',
            'bcc' => 'bcc@domain.com',
            'content' => 'content',
            'from' => 'from@domain.com',
            'sender_name' => 'Sender',
        ]);

        expect_that($model->execute(1));

        // using Yii2 module actions to check email was sent
        $this->tester->seeEmailIsSent();

        /** @var MessageInterface $emailMessage */
        $emailMessage = $this->tester->grabLastSentEmail();
        expect('valid email is sent', $emailMessage)->isInstanceOf('yii\mail\MessageInterface');
        expect($emailMessage->getTo())->hasKey('to@domain.com');
        expect($emailMessage->getFrom())->hasKey('from@domain.com');
        expect($emailMessage->getSubject())->equals('Subject');
        expect($emailMessage->toString())->stringContainsString('content');
    }
}