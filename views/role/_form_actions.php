<?php
use app\widgets\Checkbox;
use yii\helpers\Inflector;
use yii\helpers\Url;
?>
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>
                        <?= Checkbox::widget([
                            'data' => ['page' => 'PAGE'],
                            'inputClass' => '',
                            'options' => [
                                'id' => 'check_all',
                                'onclick' => 'checkAllModule(this)'
                            ],
                        ]) ?>
                    </th>
                    <th>ACTIONS</th>
                    <th>LINK</th>
                </tr>
                <?php foreach ($controller_actions as $controller => $actions) : ?>
                    <tr>
                        <td width="30%">
                            <?= Checkbox::widget([
                                'data' => [$controller => Inflector::id2camel($controller)],
                                'inputClass' => 'module_access ',
                                'options' => [
                                    'data-controller' => $controller,
                                    'onclick' => 'checkAllActions(this)'
                                ],
                            ]) ?>
                        </td>
                        <td>
                            <?= Checkbox::widget([
                                'data' => array_combine($actions, $actions),
                                'name' => "Role[module_access][{$controller}][]",
                                'inputClass' => 'module_access',
                                'options' => ['data-belongs_to' => $controller],
                                'checkedFunction' => function($key, $value) use ($model, $controller) {
                                    if (isset($model->module_access[$controller])) {
                                        if (in_array($value, $model->module_access[$controller])) {
                                            return 'checked';
                                        }
                                    }
                                },
                            ]) ?>
                        </td> 
                        <td>
                            <?php foreach ($actions as $action) : ?>
                                <label style="height: 22px;">
                                    <?= Url::to(["{$controller}/{$action}"], true) ?>
                                </label>
                                <br>
                            <?php endforeach; ?>
                        </td> 
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>