<?php
namespace app\components;

use Yii;

class ViewComponent extends \yii\web\View
{
	public function registerWidgetJs($widgetFunction, $js, $position = parent::POS_READY, $key = null)
    {
        $js = "var {$widgetFunction} = function() {
            var load = function() {
                {$js}
            }

            return {
                init: function() {
                    load();
                }
            }
        }(); {$widgetFunction}.init();";

        parent::registerjs($js, parent::POS_READY, $key);
    }
}