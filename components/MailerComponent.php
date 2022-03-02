<?php

namespace app\components;

class MailerComponent extends \yii\swiftmailer\Mailer
{
    public $useFileTransport = true;
}