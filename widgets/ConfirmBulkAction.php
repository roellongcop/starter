<?php

namespace app\widgets;

use app\helpers\App;
 
class ConfirmBulkAction extends BaseWidget
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
        return $this->render('confirm-bulk-action/index', [
            'models' => $this->models,
            'process' => $this->process,
            'post' => $this->post,
            'controllerID' => $this->controllerID,
        ]);
    }
}
