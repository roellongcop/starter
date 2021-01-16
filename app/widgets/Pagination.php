<?php
namespace app\widgets;

use Yii;
use app\helpers\App;
 
class Pagination extends \yii\base\Widget
{
    public $model;
    public $form;
    public $title = 'Pagination';
    public $attribute = 'pagination';
    public $paginations = [];
    public $select2Class;
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

        if (! $this->select2Class) {
            $this->select2Class = App::randomString();
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
            'select2Class' => $this->select2Class,
            'label' => $this->label,
        ]);
    }
}
