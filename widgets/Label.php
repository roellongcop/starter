<?php

namespace app\widgets;

class Label extends BaseWidget
{
    public $options;

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
