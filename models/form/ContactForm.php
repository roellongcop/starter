<?php

namespace app\models\form;

use app\helpers\App;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends \yii\base\Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function contact($email = '')
    {
        if ($this->validate()) {
            App::component('mailer')
                ->compose()
                ->setTo(($email ?: $this->email))
                ->setFrom([App::setting('email')->admin_email => App::setting('email')->sender_name])
                ->setReplyTo([App::setting('email')->admin_email => App::setting('email')->sender_name])
                ->setSubject($this->subject)
                ->setTextBody($this->body)
                ->send();

            return true;
        }
        return false;
    }
}