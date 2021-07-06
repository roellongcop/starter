<?php

namespace app\widgets;

use Yii;
use app\helpers\App;
use app\widgets\BootstrapSelect;
 
class RecordStatusInput extends AppWidget
{
    public $attribute = 'record_status';
    public $data;
    public $form;
    public $model;
    public $options = [
        'class' => 'kt-selectpicker form-control',
        'tabindex' => 'null',
    ]; 

    public function init() 
    {
        // your logic here
        parent::init();

        $this->data = $this->data ?:  App::mapParams('record_status');
    }


    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if (App::isLogin()) {
            if (App::identity()->can('in-active-data', $this->model->controllerID())) {
                return BootstrapSelect::widget([
                    'attribute' => $this->attribute,
                    'model' => $this->model,
                    'form' => $this->form,
                    'data' => $this->data,
                    'options' => $this->options,
                ]);
            }
        }
    }
}
