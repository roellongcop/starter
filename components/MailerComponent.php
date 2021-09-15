<?php

namespace app\components;

use Yii;

class MailerComponent extends \yii\swiftmailer\Mailer
{
    public $useFileTransport = true;
}