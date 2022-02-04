<?php

namespace app\widgets;

use app\helpers\App;
 
class BulkAction extends BaseWidget
{
    public $title = 'Bulk Action';
    
    public $controllerID;
    public $searchModel;

    public function init() 
    {
        // your logic here
        parent::init();

        $this->setControllerId();
    }

    public function setControllerId()
    {
        if ($this->controllerID == NULL) {
            if ($this->searchModel && $this->searchModel->hasProperty('controllerID')) {
                $this->controllerID = $this->searchModel->controllerID();
            }
        }

        $this->controllerID = $this->controllerID ?: App::controllerID();
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    { 
        if(! App::component('access')->userCan('bulk-action', $this->controllerID)) {
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
