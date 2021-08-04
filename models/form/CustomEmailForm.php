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
            [['to', 'subject'], 'required'],
            [['to', 'from',], 'email'],
            [['to', 'from',], 'trim'],
            [['cc', 'bcc',], 'safe'],
            [['content', 'sender_name', 'template'], 'string'],
            ['content', 'required', 'when' => function($model) {
                return $model->template == NULL;
            }],

            ['template', 'required', 'when' => function($model) {
                return $model->content == NULL;
            }],
            ['parameters', 'validateParameters'],
            [['cc', 'bcc'], 'validateCCBCC'],
        ];
    }

    public function validateCCBCC($attribute, $params)
    {
        $emails = $this->{$attribute};

        if ($emails) {
            if (is_array($emails)) {
                foreach ($emails as $email) {
                    if(! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $this->addError($attribute, "{$email} was not a valid {$attribute} email.");
                    }
                }
            }
            else {
                if(! filter_var($emails, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($attribute, "{$emails} was not a valid {$attribute} email.");
                }
            }
        }
    }

    public function validateParameters($attribute, $params)
    {
        if (!is_array($this->parameters)) {
            $this->addError($attribute, 'Parameters is not an array.');
        }
    }

    public function init()
    {
        parent::init();
        $this->from = $this->from ?: App::generalSetting('sender_email');
        $this->sender_name = $this->sender_name ?: App::generalSetting('sender_name');
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