<?php

namespace app\widgets;

use Yii;
 
class AppIcon extends BaseWidget
{
    public $icon;

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if ($icon == NULL) {
            return ;
        }
        return $this->render("icon/{$this->icon}");
    }
}
