<?php
namespace app\components;


use Yii;
use app\helpers\App;
use app\helpers\Url;
use app\models\ModelFile;
use app\models\Setting;
use app\models\search\SettingSearch;

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
        
        $this->image_holder = SettingSearch::defaultImage('image_holder');

        $settings = Setting::findAll([
            'name' => array_keys(get_object_vars($this)),
            'type' => 'general'
        ]);
        foreach ($settings as $setting) {
            if (in_array($setting->name, $setting->withImageInput)) {
                if ($setting->name != 'image_holder') {
                    $this->{$setting->name} = $this->getImagePath($setting); 
                }
            }
            else {
                $this->{$setting->name} = $setting->value; 
            }
        }
    }

    public function getImagePath($setting)
    {
        $modelFile = ModelFile::find()
            ->select([
                'MAX(id) AS id',
                'model_id',
                'file_id',
                'model_name',
                'record_status',
                'created_by',
                'updated_by',
                'created_at',
                'updated_at',
            ])
            ->where([
                'model_id' => $setting->id,
                'model_name' => 'Setting'
            ])
            ->groupBy(['file_id'])
            ->orderBy(['MAX(id)' => SORT_DESC])
            ->one();


        if ($modelFile) {
            if ($modelFile->file && $modelFile->file->isImage) {
                if(($file = $modelFile->file) != null) {
                    return Url::to(['file/display', 'token' => $file->token], true);
                }
            }
        }

        return $this->image_holder;
    }
}