<?php

namespace app\models\form\setting;

class EmailSettingForm extends SettingForm
{
    const NAME = 'email-settings';

    /* EMAIL */
    public $admin_email;
    public $sender_email;
    public $sender_name;
    public $email_change_password;
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['admin_email', 'sender_email', 'sender_name', ], 'required'],
	        [['admin_email', 'sender_email', 'sender_name', ], 'string'],
            [['admin_email', 'sender_email', ], 'trim'],
            [['admin_email', 'sender_email', ], 'email'],
	        [['email_change_password', ], 'safe'],
        ];
    }

    public function default()
    {
        return [
            'admin_email' => [
                'name' => 'admin_email',
                'default' => 'admin@example.com'
            ],
            'sender_email' => [
                'name' => 'sender_email',
                'default' => 'noreply@example.com'
            ],
            'sender_name' => [
                'name' => 'sender_name',
                'default' => 'Example.com mailer'
            ],
            'email_change_password' => [
                'name' => 'email_change_password',
                'default' => 'You\'ve Change your password'
            ]
        ];
    }
}