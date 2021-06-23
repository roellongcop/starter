<?php

namespace app\widgets;

use Yii;
use app\helpers\App;
class FilterColumn extends \yii\base\Widget
{
    public $searchModel;
    public $title = 'Filter Columns';
    public $buttonTitle = 'Filter';
    public $filterColumns;
    

    public function init() 
    {
        // your logic here
        parent::init();

        $this->filterColumns = App::identity()->filterColumns($this->searchModel);
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
            'filterColumns' => $this->filterColumns
        ]);
    }
}
