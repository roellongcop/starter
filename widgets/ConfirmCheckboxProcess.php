<?php

namespace app\widgets;

use Yii;
use app\helpers\App;
 
class ConfirmCheckboxProcess extends AppWidget
{
    public $models;
    public $process;
    public $post;
    public $controllerID;

    public function init() 
    {
        // your logic here
        parent::init(); 

        $this->controllerID = $this->controllerID ?: App::controllerID();
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('confirm-checkbox-process/index', [
            'models' => $this->models,
            'process' => $this->process,
            'post' => $this->post,
            'controllerID' => $this->controllerID,
        ]);
       
    }
}
