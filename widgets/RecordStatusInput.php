<?php

namespace app\widgets;

use app\helpers\App;
use app\models\ActiveRecord;
use app\widgets\BootstrapSelect;
 
class RecordStatusInput extends BaseWidget
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

        $this->data = $this->data ?: ActiveRecord::mapRecords();
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
