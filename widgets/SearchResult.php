<?php

namespace app\widgets;

class SearchResult extends BaseWidget
{
    public $dataProviders;
    public $searchModel;

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('search-result/index', [
            'dataProviders' => $this->dataProviders,
            'searchModel' => $this->searchModel,
        ]);
    }
        
}
