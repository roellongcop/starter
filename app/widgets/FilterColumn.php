<?php
namespace app\widgets;

use Yii;
class FilterColumn extends \yii\base\Widget
{
    public $searchModel;
    public $title = 'Filter Columns';
    public $buttonTitle = 'Filter';
    

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
        return $this->render('filter_column', [
            'searchModel' => $this->searchModel,
            'title' => $this->title,
            'buttonTitle' => $this->buttonTitle,
            'id' => $this->id,
        ]);
    }
}
