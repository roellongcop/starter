<?php

namespace app\models\form\setting;

use Yii;

class SystemSettingForm extends SettingForm
{
    public $timezone;
    public $pagination;
    public $auto_logout_timer;
    public $theme;
    public $whitelist_ip_only;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['timezone', 'pagination', 'theme', 'auto_logout_timer',], 'required'],
	        [['timezone',], 'string'],
	        [['whitelist_ip_only',], 'safe'],
	        [['pagination', 'auto_logout_timer', 'theme', 'whitelist_ip_only'], 'integer'],
        ];
    }

    public function config()
    {
        return [
            'className' => 'SystemSettingForm',
            'name' => 'system-settings',
            'defaults' => [
                'timezone' => [
                    'name' => 'timezone',
                    'default' => 'Asia/Manila',
                ],
                'pagination' => [
                    'name' => 'pagination',
                    'default' => 20,
                ],
                'auto_logout_timer' => [
                    'name' => 'auto_logout_timer',
                    'default' => 1440
                ],
                'theme' => [
                    'name' => 'theme',
                    'default' => 1,
                ],
                'whitelist_ip_only' => [
                    'name' => 'whitelist_ip_only',
                    'default' => 0,
                ],
            ]
        ];
    }
}