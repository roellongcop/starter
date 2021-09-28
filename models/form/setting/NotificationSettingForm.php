<?php

namespace app\models\form\setting;

use Yii;

class NotificationSettingForm extends SettingForm
{
    public $notification_change_password;
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
	        [['notification_change_password', ], 'safe'],
        ];
    }

    public function config()
    {
        return [
            'className' => 'NotificationSettingForm',
            'name' => 'notification-settings',
            'defaults' => [
                'notification_change_password' => [
                    'name' => 'notification_change_password',
                    'default' => 'You\'ve Change your password'
                ],
            ]
        ];
    }
}