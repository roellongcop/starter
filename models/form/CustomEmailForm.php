<?php
namespace app\models\form;

use Yii;
use app\helpers\App;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class CustomEmailForm extends Model
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

    public function rules()
    {
        return [
            [['to', 'subject', 'from'], 'required'],
            [['to', 'from',], 'email'],
            [['to', 'from',], 'trim'],
            [['cc', 'bcc', 'content', 'sender_name', 'template', 'parameters'], 'safe'],
        ];
    }

    public function init()
    {
        parent::init();
        $this->from = $this->from ?: App::setting('sender_email');
        $this->sender_name = $this->sender_name ?: App::setting('sender_name');
    }

    public function send($type = 'single')
    {
        if ($this->validate()) {

            if ($this->template) {
                $mailer = Yii::$app->mailer->compose($this->template, $this->parameters);
            }
            else {
                $mailer = Yii::$app->mailer->compose();
            }

            $mailer->setSubject($this->subject)
                ->setFrom([$this->from => $this->sender_name])
                ->setTo($this->to);

            if ($this->bcc) {
                $mailer->setBcc($this->bcc);
            }

            if ($this->cc) {
                $mailer->setBcc($this->cc);
            }
            
            if ($this->content) {
                $mailer->setHtmlBody($this->content);
            }

            switch ($type) {
                case 'multiple':
                    return $mailer;
                    break;
                
                default:
                    return $mailer->send();
                    break;
            }
        }
        return false;
    }
}