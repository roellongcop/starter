<?php

namespace app\models\form\setting;

use Yii;
use app\helpers\App;

class SystemSettingForm extends SettingForm
{
    const NAME = 'system-settings';

    const OFF = 0;
    const ON = 1;

    public $timezone;
    public $pagination;
    public $auto_logout_timer;
    public $theme;
    public $whitelist_ip_only;
    public $enable_visitor;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['timezone', 'pagination', 'theme', 'auto_logout_timer',], 'required'],
	        [['timezone',], 'string'],
	        [['whitelist_ip_only', 'enable_visitor'], 'safe'],
	        [['pagination', 'auto_logout_timer', 'theme', 'whitelist_ip_only', 'enable_visitor'], 'integer'],

	        ['pagination', 'in', 'range' => array_keys(App::params('pagination'))],
	        ['whitelist_ip_only', 'in', 'range' => array_keys(App::params('whitelist_ip_only'))],
	        ['enable_visitor', 'in', 'range' => array_keys(App::params('enable_visitor'))],
	        ['theme', 'exist', 'targetClass' => 'app\models\Theme', 'targetAttribute' => 'id'],
	        ['timezone', 'in', 'range' => array_keys(App::component('general')->timezoneList())],
        ];
    }

    public function default()
    {
        return [
            'timezone' => [
                'name' => 'timezone',
                'default' => 'Asia/Manila',
            ],
            'pagination' => [
                'name' => 'pagination',
                'default' => 25,
            ],
            'auto_logout_timer' => [
                'name' => 'auto_logout_timer',
                'default' => 1440
            ],
            'theme' => [
                'name' => 'theme',
                'default' => 2,
            ],
            'whitelist_ip_only' => [
                'name' => 'whitelist_ip_only',
                'default' => self::OFF,
            ],
            'enable_visitor' => [
                'name' => 'enable_visitor',
                'default' => self::OFF,
            ],
        ];
    }
}