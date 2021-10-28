<?php

namespace app\widgets;

use Yii;
use app\helpers\App;
 
class BulkAction extends AppWidget
{
    public $title = 'Bulk Action';
    
    public $controllerID;
    public $searchModel;


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
        if(! App::component('access')->userCan('confirm-action', $this->controllerID)) {
            return ;
        }

        return $this->render('bulk-action/index', [
            'id' => $this->id,
            'title' => $this->title,
            'searchModel' => $this->searchModel,
            'bulkActions' => $this->searchModel->bulkActions ?? ''
        ]);
    }
}
