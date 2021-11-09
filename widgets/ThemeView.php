<?php

namespace app\widgets;

use app\helpers\App;
use app\helpers\Url;
 
class ThemeView extends BaseWidget
{
    public $theme = [];
    public $currentTheme;
    public $uploadUrl;


    public function init() 
    {
        // your logic here
        parent::init();

        $this->currentTheme = App::identity('currentTheme');
        $this->uploadUrl = $this->uploadUrl ?: Url::to(['theme/change-image']);
    }


    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('theme-view', [
            'theme' => $this->theme,
            'currentTheme' => $this->currentTheme,
            'uploadUrl' => $this->uploadUrl,
            'id' => $this->id,
        ]);
    }
}
