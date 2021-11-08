<?php

namespace app\widgets;

use Yii;
use app\helpers\App;
use app\widgets\Anchor;
 
class AnchorBack extends BaseWidget
{
    public $title = 'Back';
    public $options = ['class' => 'btn btn-default'];
    public $link;
    public $tooltip;

    public function init() 
    {
        // your logic here
        parent::init();
        $this->link = $this->link ?: App::referrer();
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return Anchor::widget([
            'title' => $this->title,
            'link' => $this->link,
            'options' => $this->options,
            'tooltip' => $this->tooltip,
        ]);
    }
}
