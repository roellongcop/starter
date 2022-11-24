<?php

namespace app\components;

class MailerComponent extends \yii\symfonymailer\Mailer
{
    const TRANSPORT = [
		// LIVE
		'scheme' => 'smtps',
		'host' => 'gennakar.accessgov.ph',
		'username' => '',
		'password' => '',
		'port' => 465,
	];
	
    public $useFileTransport = true;

    // public function init()
	// {
	// 	parent::init();
	// 	$this->setTransport(self::TRANSPORT);
	// }
}