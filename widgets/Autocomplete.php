<?php

namespace app\widgets;

use Yii;
use app\helpers\Url;
 
class Autocomplete extends BaseWidget
{
    public $input;
    public $url;
    public $data = [];
    public $submitOnclick = true;

    public function init() 
    {
        // your logic here
        parent::init();
        $this->url = $this->url ?: Url::to(['find-by-keywords']);
        $this->data = json_encode($this->data);
    }

    public function ajax()
    {
        return Url::userCanRoute($this->url) ? 'true': 'false';
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('autocomplete', [
            'input' => $this->input,
            'url' => $this->url,
            'data' => $this->data,
            'submitOnclick' => $this->submitOnclick ? 'true': 'false',
            'ajax' => $this->ajax()
        ]);
    }
}
