<?php

namespace app\widgets;

use Yii;
use app\helpers\App;
use yii\helpers\Inflector;
 
class Search extends AppWidget
{
    public $placeholder = '';
    public $model;
    public $name;
    public $value;
    public $attribute = 'keywords';
    public $style = '';

    public function init() 
    {
        // your logic here
        parent::init();
        if (! $this->name) {
            $this->name = $this->attribute;
        }
        
        $this->value = $this->model->{$this->attribute};

        $this->placeholder = $this->placeholder ?: 'Search ' . $this->model->searchLabel ?? '';
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('search', [
            'placeholder' => $this->placeholder,
            'name' => $this->name,
            'value' => $this->value,
            'style' => $this->style,
        ]);
    }
}
