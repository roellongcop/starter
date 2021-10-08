<?php

namespace app\models\form\setting;

use Yii;
use app\models\File;

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
                'default' => 1
            ],
            'secondary_logo' => [
                'name' => 'secondary_logo',
                'default' => 1
            ],
            'image_holder' => [
                'name' => 'image_holder',
                'default' => 1
            ],
            'favicon' => [
                'name' => 'favicon',
                'default' => 1
            ],
        ];
    }

    public function getPrimaryLogoFile()
    {
        if ($this->primary_logo_file == NULL) {
            $this->primary_logo_file = File::findOne($this->primary_logo);
        }
        return $this->primary_logo_file;
    }

    public function getSecondaryLogoFile()
    {
        if ($this->secondary_logo_file == NULL) {
            $this->secondary_logo_file = File::findOne($this->secondary_logo);
        }
        return $this->secondary_logo_file;
    }

    public function getImageHolderFile()
    {
        if ($this->image_holder_file == NULL) {
            $this->image_holder_file = File::findOne($this->image_holder);
        }
        return $this->image_holder_file;
    }

    public function getFaviconFile()
    {
        if ($this->favicon_file == NULL) {
            $this->favicon_file = File::findOne($this->favicon);
        }
        return $this->favicon_file;
    }

    public function getFaviconPath($params=[])
    {
        if (($file = $this->faviconFile) != NULL) {
            return $file->getImagePath($params);
        }
    }

    public function getImageHolderPath($params=[])
    {
        if (($file = $this->imageHolderFile) != NULL) {
            return $file->getImagePath($params);
        }
    }
}