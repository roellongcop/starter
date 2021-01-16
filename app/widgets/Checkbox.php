<?php
namespace app\widgets;

use Yii;
 
class Checkbox extends \yii\base\Widget
{
    public $data;
    public $name;
    public $inputClass = 'checkbox';
    public $checkedFunction;
    public $options;

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
            'data' => $this->data,
            'name' => $this->name,
            'inputClass' => $this->inputClass,
            'checkedFunction' => $this->checkedFunction,
            'options' => $this->options
        ]);
       
    }
}
