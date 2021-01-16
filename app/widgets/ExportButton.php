<?php
namespace app\widgets;

use Yii;
use app\helpers\App;
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
            'icon' => 'file',
        ],
        'export-csv' => [
            'title' => 'CSV',
            'icon' => 'comfiled_file',
        ],
        'export-xls' => [
            'title' => 'XLS 95',
            'icon' => 'selected_file',
        ],

        'export-xlsx' => [
            'title' => 'XLSX 2007',
            'icon' => 'selected_file',
        ],
    ]; 

    public $exports = [];
    public $controller;
    public $title = 'Export Data';
    public $view = 'widget';

    public function init() 
    {
        // your logic here
        parent::init();

        $access = App::component('access');
        $this->controller = $this->controller ?: App::controllerID();

        foreach ($this->actions as $action => $data) {
            if ($access->userCan($action, $this->controller)) {
                $params = App::queryParams();
                array_unshift($params, $action);
                $link = Url::to($params);
                $title = $this->render("icon/{$data['icon']}") . 
                    "<span class='navi-text'> &nbsp; {$data['title']}</span>";


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
