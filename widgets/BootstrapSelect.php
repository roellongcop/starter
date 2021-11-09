<?php

namespace app\widgets;

use app\helpers\App;
 
class BootstrapSelect extends BaseWidget
{

    public $attribute = '';
    public $name;
    public $form;
    public $model;
    public $data = [];
    public $options = [
        'class' => 'kt-selectpicker form-control',
        'tabindex' => 'null',
        'prompt' => 'Select'
    ]; 
    public $searchable = true;
    public $multiple = false;
    public $label = true;


    public function init() 
    {
        // your logic here
        parent::init();

        $className = App::className($this->model);
        if (! $this->name) {
            $this->name = "{$className}[{$this->attribute}]";
        }
        $this->options['name'] = $this->name;

        if ($this->searchable) {
            if (count($this->data) > 10) {
                $this->options['data-live-search'] = 'true';
            }
            $this->options['options'] = array_map([$this, 'listOptions'], $this->data);
        }
        if ($this->multiple) {
            $this->options['multiple'] = 'true';
        }

    }

    public function listOptions($value='')
    {
        return ['data-tokens' => $value];
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $select = $this->form->field($this->model, $this->attribute)
            ->dropDownList(
                $this->data, 
                $this->options
            );

        return (!$this->label || $this->label === true)? $select: $select->label($this->label);
    }
}
