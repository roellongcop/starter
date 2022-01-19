<?php

namespace app\widgets;

use app\helpers\Html;
use app\widgets\Autocomplete;

class Search extends BaseWidget
{
    const PLACEHOLDER = 'Search';
    const DEFAULT_CLASS = 'form-control';

    public $model;
    public $attribute = 'keywords';
    public $options;

    public function init() 
    {
        // your logic here
        parent::init();

        $this->options['placeholder'] = $this->getPlaceholder();

        $this->options['class'] = $this->getClass();
        $this->options['name'] = $this->getInputName();
    }

    public function getInputName()
    {
        if (isset($this->options['name'])) {
            return $this->options['name'];
        }
        return $this->attribute;
    }

    public function getClass()
    {
        if (isset($this->options['class'])) {
            return $this->options['class'];
        }
        return self::DEFAULT_CLASS;
    }

    public function getPlaceholder()
    {
        if (isset($this->options['placeholder'])) {
            return $this->options['placeholder'];
        }

        if (isset($this->model->searchLabel)) {
            return implode(' ', [self::PLACEHOLDER, $this->model->searchLabel]);
        }

        return PLACEHOLDER;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return Autocomplete::widget([
            'input' => Html::activeInput('search', $this->model, $this->attribute, $this->options)
        ]);
    }
}
