<?php

namespace app\components;

use Yii;
use app\helpers\App;
use app\helpers\Url;
use app\models\ModelFile;
use app\models\Setting;
use app\models\form\setting\GeneralSettingForm;
use app\models\search\SettingSearch;

class SettingComponent extends \yii\base\Component
{
 	public $general;
    
	public function init()
    {
        parent::init();

        $this->general = new GeneralSettingForm();
    }

    public function general($name)
    {
        return $this->general->{$name};
    }
}