<?php
namespace app\widgets;

use Yii;
use app\helpers\App;
use app\widgets\Anchor;
use yii\grid\GridView;

 
class Grid extends \yii\base\Widget
{
    public $dataProvider;
    public $columns;
    public $options = ['class' => 'table-responsive'];
    public $pager = ['class' => 'app\widgets\LinkPager'];
    public $searchModel;
    public $template = ['view', 'update', 'delete'];
    public $controller;
    public $formatter = ['class' => '\app\components\FormatterComponent'];
    

    public function init() 
    {
        // your logic here
        parent::init();
        $filterColumns = App::identity()->filterColumns($this->searchModel);

        $columns = $this->searchModel->tableColumns();

        foreach ($columns as $key => &$column) {
            if (! isset($column['visible'])) {
                $column['visible'] = in_array($key, $filterColumns);
            }
        }
        $this->columns = $columns;

        $this->columns['actions'] = $this->columns['actions'] ?? $this->actionColumns();
        
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
                            'title' => $this->render('icon/view'). $this->actionName('View'),
                            'link' =>  ["{$controller}/view", 'id' => $model->id],
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
                            'title' => $this->render('icon/edit'). $this->actionName('Update'),
                            'link' =>  ["{$controller}/update", 'id' => $model->id],
                            'options' => [
                                'class' => 'navi-link',
                                'title' => 'Update',
                            ]
                        ]);
                    }
                },
                'delete' => function($url, $model) use ($controller) {
                    if (App::modelCan($model, 'delete')) {
                        return Anchor::widget([
                            'title' => $this->render('icon/delete'). $this->actionName('Delete'),
                            'link' =>  ["{$controller}/delete", 'id' => $model->id],
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
                            'title' => $this->render('icon/delete'). $this->actionName('Activate'),
                            'link' => ['theme/activate', 'id' => $model->id],
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
        return GridView::widget([
            'dataProvider' => $this->dataProvider,
            'options' => $this->options,
            'columns' => $this->columns,
            'pager' => $this->pager,
            'formatter' => $this->formatter,
        ]);
       
    }
}
