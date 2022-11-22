<?php

namespace app\models\form\setting;

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
                'default' => 'token-default-image_200'
            ],
            'secondary_logo' => [
                'name' => 'secondary_logo',
                'default' => 'token-default-image_200'
            ],
            'image_holder' => [
                'name' => 'image_holder',
                'default' => 'token-default-image_200'
            ],
            'favicon' => [
                'name' => 'favicon',
                'default' => 'token-default-image_200'
            ],
        ];
    }
}