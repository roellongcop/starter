<?php

namespace app\widgets;

use Yii;
use app\helpers\App;
 
class Anchors extends AppWidget
{
    public $controller;
    public $names;
    public $model;
    public $paramName = 'id';
    public $titles = [
        'index' => 'List',
        'log' => 'Data Logs',
    ];
    public $options = [
        'log' => ['class' => 'btn btn-secondary btn-bold btn-upper btn-font-sm'],
        'index' => ['class' => 'btn btn-secondary btn-bold btn-upper btn-font-sm'],
        'create' => ['class' => 'btn btn-success font-weight-bolder font-size-sm '],
        'view' => ['class' => 'btn btn-info font-weight-bolder font-size-sm '],
        'update' => ['class' => 'btn btn-primary font-weight-bolder font-size-sm '],
        'duplicate' => ['class' => 'btn btn-default font-weight-bolder font-size-sm '],
        'delete' => [
            'class' => 'btn btn-danger btn-bold btn-upper btn-font-sm ',
            'data' => [
                'confirm' => 'Are you sure you want to delete this ?',
                'method' => 'post',
            ]
        ],
    ];
    public $anchors;
    public $glue = ' ';
    public $defaultOptions = ['class' => 'btn btn-primary btn-bold btn-upper btn-font-sm'];

    public function init() 
    {
        // your logic here
        parent::init();

        $controller = $this->controller ?: App::controllerID();
        $names = is_array($this->names) ? $this->names: [$this->names];


        foreach ($names as $name) {
            $title = $this->titles[$name] ?? ucwords($name);
            $options = $this->options[$name] ?? $this->defaultOptions;

            switch ($name) { 
                case 'log':
                    $link = $this->model->logUrl;
                    break;
                case 'index':
                case 'create':
                    $link = ["{$controller}/{$name}"];
                    break;
                case 'view':
                    $link = $this->model->viewUrl;
                    break;
                case 'update':
                    $link = $this->model->updateUrl;
                    break;
                case 'duplicate':
                    $link = $this->model->duplicateUrl;
                    break;
                case 'delete':
                    $link = $this->model->deleteUrl;
                    break;
                default:
                    break;
            }

            if ($this->model) {
                if (App::modelCan($this->model, $name)) {
                    
                    $this->anchors[] = Anchor::widget([
                        'title' => $title,
                        'link' => $link,
                        'options' => $options,
                    ]);
                }
            }
            else {
                $this->anchors[] = Anchor::widget([
                    'title' => $title,
                    'link' => $link,
                    'options' => $options,
                ]);
            }
        } 
    }


 
    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return implode($this->glue, $this->anchors ?: []);
    }
}
