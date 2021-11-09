<?php

namespace app\widgets;

class AppIcon extends BaseWidget
{
    public $icon;

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if ($this->icon == NULL) {
            return ;
        }
        return $this->render("icon/{$this->icon}");
    }
}
