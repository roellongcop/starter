<?php

namespace app\widgets;

use app\helpers\App;
 
class Nestable extends BaseWidget
{
    public $controller_actions;
    public $navigations;
    public $defaultName = 'Role[main_navigation]';

    public function init() 
    {
        // your logic here
        parent::init();


       $this->controller_actions = $this->controller_actions ?: App::component('access')->controllerActions;
    }


    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('nestable/index', [
            'id' => $this->id,
            'controller_actions' => $this->controller_actions,
            'navigations' => $this->navigations,
            'defaultName' => $this->defaultName,
        ]);
    }
}
