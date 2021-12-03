<?php

use app\helpers\Html;
use app\helpers\Url;
use app\widgets\Checkbox;
use yii\helpers\Inflector;
?>

<div class="card">
    <div class="card-header">
        <div class="card-title collapsed" 
            data-toggle="collapse" 
            data-target="#collapse-<?= $controller ?>">
            <?= Inflector::camel2words(Inflector::id2camel($controller)) ?>
        </div>
    </div>
    <div id="collapse-<?= $controller ?>" class="collapse" 
        data-parent="#module-access-accordion">
        <div class="card-body">
            <?= Checkbox::widget([
                'data' => [$controller => 'Check All Actions'],
                'inputClass' => 'module_access checkbox',
                'options' => [
                    'data-controller' => $controller,
                    'onclick' => 'checkAllActions(this)'
                ],
            ]) ?>
            <br>
            <div style="display: flex;">
                <div>
                    <?= Checkbox::widget([
                        'data' => array_combine($actions, $actions),
                        'name' => "Role[module_access][{$controller}][]",
                        'inputClass' => 'module_access checkbox',
                        'options' => ['data-belongs_to' => $controller],
                        'checkedFunction' => function($value) use ($model, $controller) {
                            return Html::if(isset($model->module_access[$controller]) && in_array($value, $model->module_access[$controller]), 'checked');
                        },
                    ]) ?>
                </div>
                <div class="ml-10">
                    <div class="checkbox-list">
                        <?= Html::foreach($actions, function($action) use ($controller) {
                            return '<label class="checkbox">'
                                . Url::to(["{$controller}/{$action}"], true) .
                                '</label>';
                        }) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>