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
        if ($this->icon == null) {
            return;
        }
        return $this->render("icon/{$this->icon}");
    }
}