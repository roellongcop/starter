<?php
namespace app\widgets;

use Yii;
use app\helpers\App;
use yii\helpers\Url;
 
class Switcher extends \yii\base\Widget
{
    public $model;
    public $checked;
    public $onchange;
    public $data_link;
    public $controller;
    public $action;

    public function init() 
    {
        // your logic here
        parent::init();
        // $this->controller = $this->controller ?: App::controllerID();

        $this->data_link = Url::to([$this->controller . '/' . $this->action]);
        $this->controller = $this->controller ?: App::controllerID();
    }


    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('switcher', [
            'model' => $this->model,
            'checked' => $this->checked,
            'onchange' => $this->onchange,
            'data_link' => $this->data_link,
            'id' => $this->id,
        ]);
    }
}
