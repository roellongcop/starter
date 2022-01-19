<?php

namespace app\widgets;

use Yii;
use app\helpers\Url;
 
class Autocomplete extends BaseWidget
{
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
            'input' => $this->input,
            'url' => $this->url,
        ]);
    }
}
