<?php

namespace app\models\form\setting;

use Yii;

class ImageSettingForm extends SettingForm
{
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

    public function config()
    {
        return [
            'className' => 'ImageSettingForm',
            'name' => 'image-settings',
            'defaults' => [
                'primary_logo' => [
                    'name' => 'primary_logo',
                    'default' => '/file/display?token=default-6ccb4a66-0ca3-46c7-88dd-default&w=200'
                ],
                'secondary_logo' => [
                    'name' => 'secondary_logo',
                    'default' => '/file/display?token=default-6ccb4a66-0ca3-46c7-88dd-default&w=200'
                ],
                'image_holder' => [
                    'name' => 'image_holder',
                    'default' => '/file/display?token=default-6ccb4a66-0ca3-46c7-88dd-default&w=200'
                ],
                'favicon' => [
                    'name' => 'favicon',
                    'default' => '/file/display?token=default-6ccb4a66-0ca3-46c7-88dd-default&w=200'
                ],
            ]
        ];
    }
}