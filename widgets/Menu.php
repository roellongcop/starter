<?php

namespace app\widgets;

use app\helpers\App;
 
class Menu extends BaseWidget
{
    public $menus;
    public $viewParams;

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
            'menus' => $this->menus,
            'viewParams' => $this->viewParams,
        ]);
    }
}
