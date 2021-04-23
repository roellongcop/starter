<?php

namespace app\models\form;

use Yii;
use app\helpers\App;
use app\models\Log;
use app\models\Setting;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class SettingForm extends Model
{
    public $timezone;
    public $pagination;
    public $admin_email;
    public $sender_email;
    public $sender_name;
    public $primary_logo;
    public $secondary_logo;
    public $image_holder;
    public $favicon;
    public $auto_logout_timer;
    public $theme;
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
                    'theme',
            	], 
	            'string'
	        ],

	        [
            	[
				    'admin_email',
				    'sender_email',
            	], 
	            'email'
	        ],

	        [
            	[
				    'pagination',
				    'auto_logout_timer',
            	], 
	            'integer'
	        ],

	        [
                [
                	'primary_logo',
				    'secondary_logo',
				    'image_holder',
				    'favicon',
                ], 
                'image', 
                // 'minWidth' => 100,
                // 'maxWidth' => 200,
                // 'minHeight' => 100,
                // 'maxHeight' => 200,
                'maxSize' => 1024 * 1024 * 2,
                'skipOnEmpty' => true, 
                'extensions' => App::params('file_extensions')['image'], 
                'checkExtensionByMimeType' => false
            ],
        ];
    }

    public function init()
    {
        parent::init();

        $general_settings = App::params('general_settings');
        foreach ($general_settings as $setting) {
            if ($this->hasProperty($setting['name'])) {
                $this->{$setting['name']} = $setting['default']; 
            }
        }

        $settings = Setting::find()
            ->where(['name' => array_keys($this->attributes)])
            ->general()
            ->all();

        foreach ($settings as $setting) {
            if (in_array($setting->name, $setting->withImageInput)) {
                $this->{$setting->name} = $setting->imagepath; 
            }
            else {
                $this->{$setting->name} = $setting->value; 
            }
        }
    }

    public function save()
    {
        $changeAttribute = [];

        foreach ($this->attributes as $attribute => $value) {
            $setting = Setting::find()
                ->where(['name' => $attribute])
                ->general()
                ->one();

            $setting = $setting ?: new Setting();
            $setting->name = $attribute;
            $setting->logAfterSave = false;
            $setting->record_status = 1;
            $setting->type = 'general';

            if ($setting->value != $value) {
                $changeAttribute[$attribute] = $value;
            }

            if (in_array($attribute, $setting->withImageInput)) {
                $setting->imageInput = UploadedFile::getInstance($this, $attribute);
                if ($setting->imageInput) {
                    $setting->value = "{$setting->imageInput->baseName}.{$setting->imageInput->extension}";
                    $setting->record_status = 1;
                    if ($setting->save()) {
                        $setting->upload();
                    }
                    else {
                        App::danger($setting->errors);
                    }
                }
            }
            else {
                $setting->value = $value;
                if ($setting->save()) {
                }
                else {
                    App::danger($setting->errors);
                }
            }
        }
        Log::record(new Setting(['type' => 'general']), $changeAttribute);
    }
 
}
