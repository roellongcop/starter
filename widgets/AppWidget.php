<?php

namespace app\widgets;

use Yii;
use app\helpers\App;
use yii\helpers\Inflector;
 
class AppWidget extends \yii\base\Widget
{
    public $widgetFunction;

    public function init() 
    {
        // your logic here
        parent::init();
        $this->widgetFunction = Inflector::id2camel($this->getId());
    }

    public function getWidgetFunction()
    {
        return $this->widgetFunction;
    }

    public function render($view, $params = [])
    {
        $params['widgetId'] = $this->getId();
        $params['widgetFunction'] = "widget{$this->widgetFunction}";
        return parent::render($view, $params);
    }
}
