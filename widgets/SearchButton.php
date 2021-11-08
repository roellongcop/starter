<?php

namespace app\widgets;

use Yii;
 
class SearchButton extends BaseWidget
{
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
        return $this->render('search_button');
    }
}
