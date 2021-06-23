<?php

namespace app\widgets;

use Yii;
use app\helpers\App;
 
class BulkAction extends \yii\base\Widget
{
    public $title = 'Bulk Action';
    
    public $controller;
    public $searchModel;


    public function init() 
    {
        // your logic here
        parent::init();

        $this->controller = $this->controller ?: App::controllerID();
    }


    /**
     * {@inheritdoc}
     */
    public function run()
    { 
        return $this->render('bulk_action', [
            'id' => $this->id,
            'title' => $this->title,
            'searchModel' => $this->searchModel,
        ]);
    }
}
