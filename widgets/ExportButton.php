<?php

namespace app\widgets;

use Yii;
use app\helpers\App;
use app\helpers\Html;
use yii\helpers\Url; 
 
class ExportButton extends \yii\base\Widget
{
    public $actions = [
        'print' => [
            'title' => 'Print',
            'icon' => 'print',
        ],
        'export-pdf' => [
            'title' => 'PDF',
            'icon' => 'pdf',
        ],
        'export-csv' => [
            'title' => 'CSV',
            'icon' => 'csv',
        ],
        'export-xls' => [
            'title' => 'XLS 95',
            'icon' => 'excel',
        ],
        'export-xlsx' => [
            'title' => 'XLSX 2007',
            'icon' => 'excel',
        ],
    ]; 
    
    public $exports = [];
    public $controller;
    public $title = 'Export Data';
    public $view = 'widget';
    public $user;

    public function init() 
    {
        // your logic here
        parent::init();

        if (App::isLogin()) {
            $this->user = $this->user ?: App::identity();
        }

        $access = App::component('access');
        $this->controller = $this->controller ?: App::controllerID();

        foreach ($this->actions as $action => $data) {
            if ($this->user->can($action, $this->controller)) {
                $params = App::queryParams();
                array_unshift($params, $action);
                $link = Url::to($params);

                $icon = Html::isHtml($data['icon'])? $data['icon']: $this->render("icon/{$data['icon']}");

                $title = "{$icon}<span class='navi-text'> &nbsp; {$data['title']}</span>";


                if ($action == 'print') {
                    $this->exports[] = Anchor::widget([
                        'title' => $title,
                        'link' => '#',
                        'options' => [
                            'class' => 'navi-link',
                            'onclick' => "popupCenter('{$link}')"
                        ]
                    ]);
                }
                else {
                    $this->exports[] = Anchor::widget([
                        'title' => $title,
                        'link' => $link,
                        'options' => ['class' => 'navi-link']
                    ]);
                }
            }
        }
    }


    /**
     * {@inheritdoc}
     */
    public function run()
    { 
        return $this->render('export_button', [
            'exports' => $this->exports,
            'title' => $this->title,
        ]); 
    }
}
