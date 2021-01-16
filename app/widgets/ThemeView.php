<?php
namespace app\widgets;

use Yii;
use app\helpers\App;
use app\models\File;
use app\models\form\ThemeForm;
use app\models\search\SettingSearch;
 
class ThemeView extends \yii\base\Widget
{
    public $theme = [];
    public $currentTheme;

    public function init() 
    {
        // your logic here
        parent::init();

        $this->currentTheme = App::identity('currentTheme');
    }


    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('theme_view', [
            'theme' => $this->theme,
            'currentTheme' => $this->currentTheme,
        ]);
    }
}
