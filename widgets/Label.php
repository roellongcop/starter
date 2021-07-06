<?php

namespace app\widgets;

use Yii;
use app\helpers\App;
 
class Label extends AppWidget
{
    public $options;

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
        return $this->render('label', [
            'options' => $this->options
        ]);
    }
}
