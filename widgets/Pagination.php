<?php

namespace app\widgets;

use app\helpers\App;
 
class Pagination extends BaseWidget
{
    public $model;
    public $form;
    public $title = 'Pagination';
    public $attribute = 'pagination';
    public $paginations = [];
    public $name;
    public $label = false;

    public function init() 
    {
        // your logic here
        parent::init();

        if (! $this->name) {
            $this->name = $this->attribute;
        }

        if (! $this->paginations) {
            $this->paginations = App::params('pagination');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('pagination', [
            'title' => $this->title,
            'form' => $this->form,
            'model' => $this->model,
            'name' => $this->name,
            'attribute' => $this->attribute,
            'paginations' => $this->paginations,
            'label' => $this->label,
        ]);
    }
}
