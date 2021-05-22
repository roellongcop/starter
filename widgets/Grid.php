<?php
namespace app\widgets;

use Yii;
use app\helpers\App;
use app\widgets\Anchor;

 
class Grid extends \yii\base\Widget
{
    public $dataProvider;
    public $columns;
    public $options = ['class' => 'table-responsive'];
    public $pager = ['class' => 'yii\widgets\LinkPager'];
    public $searchModel;
    public $template = ['view', 'update', 'duplicate', 'delete'];
    public $controller;
    public $formatter = ['class' => '\app\components\FormatterComponent'];
    
    public $paramName = 'id';
    public $layout;
    public function init() 
    {
        // your logic here
        parent::init();
        $currentTheme = App::identity('currentTheme');
        $keenThemes = App::params('keen_themes');
        if (in_array($currentTheme->slug, $keenThemes)) {
            $this->pager['class'] = 'app\widgets\LinkPager';
        }

        $filterColumns = App::identity()->filterColumns($this->searchModel);

        $columns = $this->searchModel->tableColumns;

        foreach ($columns as $key => &$column) {
            if (! isset($column['visible'])) {
                $column['visible'] = in_array($key, $filterColumns);
            }
        }
        $this->columns = $columns;

        $this->columns['actions'] = $this->columns['actions'] ?? $this->actionColumns();
        $this->layout = $this->layout ?: $this->render('grid/layout');
    }

    public function actionName($name)
    {
        return "<span class='navi-text'> &nbsp; {$name}</span>";
    }

    public function actionColumns()
    {
        if (isset($searchModel->actionColumn)) {
            return $searchModel->actionColumn;
        }

        $controller = $this->controller ?: App::controllerID();
        $template = [];
        foreach ($this->template as $_template) {
            $explode_template = explode(':', $_template);

            $_controller = $explode_template[1] ?? $controller;
            $action = $explode_template[0] ?? '';

            if (App::component('access')->userCan($action, $_controller)) {
                $template[] = '{'.$action.'}';
            }
        }
        return [
            'class' => 'yii\grid\ActionColumn',
            'header' => '<span style="color:#3699FF">Actions</span>',
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-center', 'width' => '70'],
            'template' => $this->render('grid/grid_action', ['template' => $template ]),

            'buttons' => [
                'view' => function($url, $model) use($controller) {
                    if (App::modelCan($model, 'view')) {
                        return Anchor::widget([
                            'title' => '<i class="glyphicon glyphicon-eye-open text-info"></i>'. $this->actionName('View'),
                            'link' =>  $model->viewUrl,
                            'options' => [
                                'class' => 'navi-link',
                                'title' => 'View',
                            ]
                        ]);
                    }
                },
                'update' => function($url, $model) use ($controller){
                    if (App::modelCan($model, 'update')) {
                        return Anchor::widget([
                            'title' => '<i class="glyphicon glyphicon-edit text-warning"></i>'. $this->actionName('Update'),
                            'link' =>  $model->updateUrl,
                            'options' => [
                                'class' => 'navi-link',
                                'title' => 'Update',
                            ]
                        ]);
                    }
                },
                'duplicate' => function($url, $model) use ($controller){
                    if (App::modelCan($model, 'duplicate')) {
                        return Anchor::widget([
                            'title' => '<i class="glyphicon glyphicon-copy text-default"></i>'. $this->actionName('Duplicate'),
                            'link' =>  $model->duplicateUrl,
                            'options' => [
                                'class' => 'navi-link',
                                'title' => 'Duplicate',
                            ]
                        ]);
                    }
                },
                'delete' => function($url, $model) use ($controller) {
                    if (App::modelCan($model, 'delete')) {
                        return Anchor::widget([
                            'title' => '<i class="glyphicon glyphicon-trash text-danger"></i>'. $this->actionName('Delete'),
                            'link' =>  $model->deleteUrl,
                            'options' => [
                                'class' => 'navi-link delete',
                                'title' => 'Delete',
                                'data-method' => 'post',
                                'data-confirm' => "Delete ?",
                            ]
                        ]);
                    }
                }, 
                'activate' => function($url, $model) use ($controller) {
                    if (App::modelCan($model, 'activate')) {
                        return Anchor::widget([
                            'title' => '<i class="glyphicon glyphicon-ok text-success"></i>'. $this->actionName('Activate'),
                            'link' => $model->activateUrl,
                            'options' => [
                                'class' => 'navi-link delete',
                                'data-method' => 'post',
                                'data-confirm' => 'Are you sure ?'
                            ]
                        ]) ;
                    }
                }, 

            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('grid/index', [
            'id' => $this->id,
            'layout' => $this->layout,
            'dataProvider' => $this->dataProvider,
            'options' => $this->options,
            'columns' => $this->columns,
            'pager' => $this->pager,
            'formatter' => $this->formatter,
        ]);
       
    }
}
