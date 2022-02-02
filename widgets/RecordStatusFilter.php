<?php

namespace app\widgets;

use app\helpers\App;
use app\models\ActiveRecord;
use app\widgets\Filter;
 
class RecordStatusFilter extends BaseWidget
{
    public $form;
    public $model;
    public $controllerId;

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
        if (App::isLogin()) {
            if (App::identity()->can('in-active-data', $this->model->controllerID())) {
                return Filter::widget([
                    'data' => ActiveRecord::mapRecords(),
                    'title' => 'Record Status',
                    'attribute' => 'record_status',
                    'model' => $this->model,
                    'form' => $this->form,
                ]);
            }
        }
    }
}
