<?php

use app\helpers\App;
use app\models\UserMeta;
use yii\helpers\Html;
use yii\helpers\Inflector;
$model = new UserMeta();


$this->registerJs(<<< SCRIPT
$('.check-all-filter').on('change', function() {
    var is_checked = $(this).is(':checked');

    var inputs = $(this).parents('.dropdown-menu').find('input._filter_column_checkbox');

    if (is_checked) {
        inputs.prop('checked', true);
    }
    else {
        inputs.prop('checked', false);
    }
})
SCRIPT, \yii\web\View::POS_END);

?> 


<div class="dropdown text-right">
    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
        <?= $title ?>
        <span class="caret"></span>
    </button>
    <div class="dropdown-menu dropdown-menu-right">
        <?= Html::beginForm(['user-meta/filter']); ?>
            <?= Html::activeInput('hidden', $model, 'table_name', [
                'value' => App::tableName($searchModel, false)
            ]) ?>

            <label style="margin-left: 20px;">
                <input type="checkbox" class="check-all-filter">
                <span></span>
                CHECK ALL
            </label>
            <ul> 
                <?php foreach ($searchModel->tableColumns as $key => $value): ?>
                    <li> 
                        <label class="checkbox ">
                            <?= Html::activeInput('checkbox', $model, 'columns[]', [
                                'value' => $key,
                                'class' => '_filter_column_checkbox',
                                'checked' => in_array($key, $filterColumns)
                            ]) ?>
                            <span></span>
                            <?= Inflector::humanize(strtoupper($key)) ?>
                        </label>
                    </li>
                <?php endforeach ?>
            </ul>

            <button type="submit" class="btn btn-primary btn-block btn-sm">
                <?= $buttonTitle ?>
            </button>
        <?= Html::endForm(); ?> 
    </div>
</div>