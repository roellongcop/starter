<?php

namespace app\widgets;

use Yii;
use app\helpers\App;
use app\widgets\Switcher;
use app\helpers\Url;
 
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
            return $this->render('record_html', [
                'model' => $this->model
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
