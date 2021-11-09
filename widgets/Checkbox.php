<?php

namespace app\widgets;

class Checkbox extends BaseWidget
{
    public $data;
    public $name;
    public $inputClass = 'checkbox';
    public $checkedFunction;
    public $options;
    public $label;
    public $wrapperClass = 'checkbox-list';

    public function init() 
    {
        // your logic here
        parent::init(); 

        if ($this->options) {
            $link = [];

            foreach ($this->options as $key => $value) {
                $link[] = "{$key}='{$value}'";
            }

            $this->options = implode(' ', $link);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('checkbox', [
            'label' => $this->label,
            'wrapperClass' => $this->wrapperClass,
            'data' => $this->data,
            'name' => $this->name,
            'inputClass' => $this->inputClass,
            'checkedFunction' => $this->checkedFunction,
            'options' => $this->options
        ]);
       
    }
}
