<?php
namespace app\widgets;

use Yii;
use app\helpers\App;
 
class Menu extends \yii\base\Widget
{
    public $menus;

    public function init() 
    {
        // your logic here
        parent::init();

        $this->menus = $this->menus ?: App::identity('main_navigation');

    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('menu/index', [
            'menus' => $this->menus
        ]);
    }
}
