<?php

namespace app\models\form\setting;

use Yii;

class NotificationSettingForm extends SettingForm
{
    const NAME = 'notification-settings';

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

    public function default()
    {
        return [
            'notification_change_password' => [
                'name' => 'notification_change_password',
                'default' => 'You\'ve Change your password'
            ],
        ];
    }
}