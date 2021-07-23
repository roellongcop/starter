<?php
use app\widgets\Checkbox;
use yii\helpers\Inflector;
use yii\helpers\Url;
?>
<div class="row">
    <div class="col-md-8">
        <?= Checkbox::widget([
            'data' => ['page' => 'Check All Access'],
            'inputClass' => 'checkbox',
            'options' => [
                'id' => 'check_all',
                'onclick' => 'checkAllModule(this)'
            ],
        ]) ?>
        <hr>
        <div class="accordion accordion-toggle-arrow" id="module-access-accordion">
            <?php foreach ($controller_actions as $controller => $actions) : ?>
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
                            <hr>
                            <div style="display: flex;">
                                <div>
                                    <?= Checkbox::widget([
                                        'data' => array_combine($actions, $actions),
                                        'name' => "Role[module_access][{$controller}][]",
                                        'inputClass' => 'module_access checkbox',
                                        'options' => ['data-belongs_to' => $controller],
                                        'checkedFunction' => function($key, $value) use ($model, $controller) {
                                            if (isset($model->module_access[$controller])) {
                                                if (in_array($value, $model->module_access[$controller])) {
                                                    return 'checked';
                                                }
                                            }
                                        },
                                    ]) ?>
                                </div>
                                <div class="ml-10">
                                    <div class="checkbox-list">
                                        <?php foreach ($actions as $action) : ?>
                                            <label class="checkbox">
                                                <?= Url::to(["{$controller}/{$action}"], true) ?>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>