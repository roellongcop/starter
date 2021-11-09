<?php

namespace app\widgets;

class SearchButton extends BaseWidget
{
    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('search-button');
    }
}
