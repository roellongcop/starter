<?php

namespace app\widgets;

use Yii;
use app\helpers\Url;
 
class Autocomplete extends BaseWidget
{
    public $inputId;
    public $input;
    public $url;

    public function init() 
    {
        // your logic here
        parent::init();
        $this->url = $this->url ?: Url::to(['find-by-keyword']);
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('autocomplete', [
            'inputId' => $this->inputId,
            'input' => $this->input,
            'url' => $this->url,
        ]);
    }
}
