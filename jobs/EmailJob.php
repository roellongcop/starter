<?php

namespace app\jobs;

use Yii;
use app\models\form\CustomEmailForm;

class EmailJob extends \yii\base\BaseObject implements \yii\queue\JobInterface
{
    public $to;
    public $subject = 'Subject';
    public $cc;
    public $bcc;
    public $content;
    public $from;
    public $sender_name;
    public $template;
    public $parameters = [];
    
    public function execute($queue)
    {
    	$mail = new CustomEmailForm([
            'to' => $this->to,
            'subject' => $this->subject,
            'cc' => $this->cc,
            'bcc' => $this->bcc,
            'content' => $this->content,
            'from' => $this->from,
            'sender_name' => $this->sender_name,
            'template' => $this->template,
            'parameters' => $this->parameters,
        ]);

        return $mail->send();
    }
}