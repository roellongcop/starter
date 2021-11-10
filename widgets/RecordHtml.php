<?php

namespace app\widgets;

use app\helpers\App;
use app\helpers\Html;
use app\widgets\Switcher;
 
class RecordHtml extends BaseWidget
{
    public $model;
    public $labelOnly = false;
    public $controller;
    public $action = 'change-record-status';

    public function init() 
    {
        // your logic here
        parent::init();
    }


    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if ($this->labelOnly) {
            return Html::tag('span', $this->model->recordStatus['label'], [
                'class' => 'badge badge-' . $this->model->recordStatus['class']
            ]);
        }

        return Switcher::widget([
            'model' => $this->model,
            'checked' => ($this->model->record_status == 1),
            'controller' => $this->controller ?: App::controllerID(),
            'action' => $this->action,
        ]);
    }
}
