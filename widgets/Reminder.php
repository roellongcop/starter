<?php

namespace app\widgets;

use Yii;

class Reminder extends BaseWidget
{
    public $head;
    public $message;
    public $type = 'success';
    public $withClose = true;
    public $icon;
    public $withDot = true;


    public function init()
    {
        parent::init();
        if ($this->message && $this->withDot) {
            $this->message = (substr($this->message, -1) == '.') ? $this->message: $this->message . '.';
        }

        switch ($this->type) {
            case 'success':
                $this->icon = '<i class="fas fa-check-circle"></i>';
                break;

            case 'info':
                $this->icon = '<i class="fas fa-question-circle"></i>';
                break;

            case 'danger':
                $this->icon = '<i class="fas fa-window-close"></i>';
                break;

            case 'primary':
                $this->icon = '<i class="fas fa-info-circle"></i>';
                break;

            case 'warning':
                $this->icon = '<i class="fa fa-exclamation-triangle"></i>';
                break;

            default:
                $this->icon = '<i class="far fa-check-circle"></i>';
                break;
        }
    }
    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('reminder', [
            'head' => $this->head,
            'message' => $this->message,
            'type' => $this->type,
            'withClose' => $this->withClose,
            'icon' => $this->icon,
        ]);
    }

}
