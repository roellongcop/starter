<?php

namespace app\widgets;

use app\helpers\Html;
use app\widgets\BootstrapSelect;

class Filter extends BaseWidget
{
    public $attribute;
    public $data = [];
    public $model;
    public $inputs;
    public $title;
    public $name;
    public $form;

    public function init()
    {
        // your logic here
        parent::init();

        if (!$this->name) {
            $this->name = "{$this->attribute}[]";
        }

        $filters = $this->model->{$this->attribute} ?? [];
        $filters = is_array($filters) ? $filters : [$filters];

        foreach ($this->data as $id => $name) {
            $checked = in_array($id, $filters) ? 'checked' : '';

            $_name = is_array($name) ? $name['name'] : $name;
            $tags = is_array($name) ? $name['tags'] : '';

            $this->inputs .= $this->render('filter/checkbox', [
                'id' => $id,
                'tags' => $tags,
                'name' => $_name,
                'checked' => $checked,
                'inputName' => $this->name,
            ]);
        }

        if (!$this->title && $this->title !== false) {
            $this->title = ucwords(str_replace('_', ' ', $this->attribute));
        }

    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if (count($this->data) <= 1) {
            return;
        }

        if (count($this->data) > 20) {
            return Html::tag('div', BootstrapSelect::widget([
                'attribute' => $this->attribute,
                'model' => $this->model,
                'form' => $this->form,
                'data' => $this->data,
                'name' => $this->name,
                'multiple' => true
            ]), ['class' => 'mt-5']);
        }

        if ($this->data) {
            return $this->render('filter/index', [
                'title' => $this->title,
                'inputs' => $this->inputs,
            ]);
        }
    }
}