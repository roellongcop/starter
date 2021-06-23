<?php

namespace app\widgets;

use Yii;
use app\helpers\App;
use app\models\File;
use app\models\form\ThemeForm;
use yii\helpers\Url;
 
class ThemeView extends \yii\base\Widget
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
        return $this->render('theme_view', [
            'theme' => $this->theme,
            'currentTheme' => $this->currentTheme,
            'uploadUrl' => $this->uploadUrl,
            'id' => $this->id,
        ]);
    }
}
