<?php
namespace app\widgets;

use Yii;
use app\helpers\App;
 
class Nestable extends \yii\base\Widget
{
    public $controller_actions;
    public $role;

    public function init() 
    {
        // your logic here
        parent::init();


       $this->controller_actions = $this->controller_actions ?: App::component('access')->controllerActions();
    }


    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('nestable/index', [
            'controller_actions' => $this->controller_actions,
            'role' => $this->role,
            'widget_id' => $this->id,
        ]);
    }
}
