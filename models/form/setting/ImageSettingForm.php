<?php

namespace app\models\form\setting;

use Yii;

class ImageSettingForm extends SettingForm
{
    const NAME = 'image-settings';
    /* EMAIL */
    public $primary_logo;
    public $secondary_logo;
    public $image_holder;
    public $favicon;
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['primary_logo', 'secondary_logo', 'image_holder', 'favicon', ], 'string'],
            [['primary_logo', 'secondary_logo', 'image_holder', 'favicon', ], 'safe'],
        ];
    }

    public function default()
    {
        return [
            'primary_logo' => [
                'name' => 'primary_logo',
                'default' => 'default-6ccb4a66-0ca3-46c7-88dd-default'
            ],
            'secondary_logo' => [
                'name' => 'secondary_logo',
                'default' => 'default-6ccb4a66-0ca3-46c7-88dd-default'
            ],
            'image_holder' => [
                'name' => 'image_holder',
                'default' => 'default-6ccb4a66-0ca3-46c7-88dd-default'
            ],
            'favicon' => [
                'name' => 'favicon',
                'default' => 'default-6ccb4a66-0ca3-46c7-88dd-default'
            ],
        ];
    }
}