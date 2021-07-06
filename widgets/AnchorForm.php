<?php

namespace app\widgets;

use Yii;
use app\widgets\AnchorBack;
use yii\helpers\Html;
 
class AnchorForm extends \yii\base\Widget
{
    public $glue = ' ';
    public $submitLabel = 'Save';

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
        $anchors = [
            AnchorBack::widget(),
            Html::submitButton($this->submitLabel, [
                'class' => 'btn btn-success',
                'name' => 'confirm_button',
                'value' => $this->submitLabel
            ])
        ];

        return implode($this->glue, $anchors);
    }
}
