<?php

namespace tests\unit\components;

use app\helpers\App;

class ViewComponentTest extends \Codeception\Test\Unit
{
    public function testRegisterWidgetJs()
    {
        \Yii::$app->view->registerWidgetJs('test', 'alert()', \yii\web\View::POS_READY, 'key');

        expect(\Yii::$app->view->js)->hasKey(\yii\web\View::POS_READY);
        expect(\Yii::$app->view->js[\yii\web\View::POS_READY])->hasKey('key');
    }
}