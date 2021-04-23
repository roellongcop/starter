<?php
namespace app\components;


use Yii;
use app\helpers\App;
use app\models\Setting;

class SettingComponent extends \yii\base\Component
{
	/* GENERAL */
 	public $timezone;
    public $pagination;
    public $auto_logout_timer;
    public $theme;

    /* EMAIL */
    public $admin_email;
    public $sender_email;
    public $sender_name;

    /* IMAGE */
	public $primary_logo;
    public $secondary_logo;
    public $image_holder;
    public $favicon;
    

	public function init()
    {
        parent::init();


        $general_settings = App::params('general_settings');
        foreach ($general_settings as $setting) {
            if ($this->hasProperty($setting['name'])) {
                $this->{$setting['name']} = $setting['default']; 
            }
        }

        $settings = Setting::findAll([
            'name' => array_keys(get_object_vars($this)),
            'type' => 'general'
        ]);
        foreach ($settings as $setting) {
            if (in_array($setting->name, $setting->withImageInput)) {
                $this->{$setting->name} = $setting->imagepath; 
            }
            else {
                $this->{$setting->name} = $setting->value; 
            }
        }
    }
}