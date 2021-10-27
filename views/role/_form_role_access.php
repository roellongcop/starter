<?php

use app\widgets\Checkbox;
use app\models\search\RoleSearch;
?>
<?= Checkbox::widget([
    'data' => ['check_all' => '<b>Check All</b>'],
    'options' => ['onclick' => 'checkAllRole(this)'],
]) ?>
<p></p>
<?= Checkbox::widget([
    'data' => RoleSearch::getAllRecord(),
    'name' => 'Role[role_access][]',
    'inputClass' => 'checkbox role_access',
    'checkedFunction' => function($key, $value) use ($model) {
        return isset($model->role_access) && in_array($key, $model->role_access) ? 'checked': '';
    }
]) ?>