<?php
namespace app\widgets;

use Yii;
use yii\widgets\DetailView;

 
class Detail extends \yii\base\Widget
{
    public $model;
    public $formatter = ['class' => '\app\components\FormatterComponent'];
    

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
        return DetailView::widget([
            'model' => $this->model,
            'attributes' => $this->model->detailColumns ?? ['id'],
            'formatter' => $this->formatter,
        ]);
       
    }
}
