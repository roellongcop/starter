<?php

namespace app\models\form\setting;

use Yii;
use app\helpers\App;
use app\models\Setting;
use yii\helpers\ArrayHelper;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class GeneralSettingForm extends \yii\base\Model
{
    /* GENERAL */
    public $timezone;
    public $pagination;
    public $auto_logout_timer;
    public $theme;
    public $whitelist_ip_only;

    /* EMAIL */
    public $admin_email;
    public $sender_email;
    public $sender_name;

    /* IMAGE */
    public $primary_logo;
    public $secondary_logo;
    public $image_holder;
    public $favicon;

    /* Notification */
    public $notification_change_password;

    /* Email */
    public $email_change_password;
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [
            	[
            		'timezone',
				    'pagination',
				    'admin_email',
				    'sender_email',
				    'sender_name',
				    'theme',
				    'auto_logout_timer',
            	], 
	            'required'
	        ],

	        [
                [
                    'timezone', 
                    'admin_email', 
                    'sender_email', 
                    'sender_name', 
                    'primary_logo', 
                    'secondary_logo', 
                    'image_holder', 
                    'favicon',
                ], 
                'string'
            ],

            [['admin_email', 'sender_email', ], 'trim'],
            [['admin_email', 'sender_email', ], 'email'],
	        [
                [
                    'whitelist_ip_only', 
                    'notification_change_password', 
                    'email_change_password', 
                    'primary_logo', 
                    'secondary_logo', 
                    'image_holder', 
                    'favicon',
                ], 
                'safe'
            ],

	        [['pagination', 'auto_logout_timer', 'theme', 'whitelist_ip_only'], 'integer'],
        ];
    }

    public function init()
    {
        parent::init();

        $this->load(['SettingForm' => ArrayHelper::map(Setting::GENERAL, 'name', 'default')]);
    }
}