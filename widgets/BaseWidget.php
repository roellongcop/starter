<?php

namespace app\widgets;

use yii\helpers\Inflector;
 
class BaseWidget extends \yii\base\Widget
{
    public $widgetFunction;

    public function init() 
    {
        // your logic here
        parent::init();
        $this->widgetFunction = $this->getWidgetFunction();
    }

    public function getWidgetFunction()
    {
        if ($this->widgetFunction == null) {
            $this->widgetFunction = Inflector::id2camel($this->getId());
        }
        
        return $this->widgetFunction;
    }

    public function render($view, $params = [])
    {
        $params['widgetId'] = $this->getId();
        $params['widgetFunction'] = "widget{$this->widgetFunction}";
        return parent::render($view, $params);
    }
}
