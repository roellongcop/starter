<?php

use app\helpers\App;
use app\models\UserMeta;
use app\helpers\Html;
use yii\helpers\Inflector;

$model = new UserMeta();

$this->registerWidgetJsFile('filter-column');
$this->registerJs(<<< JS
    new FilterColumnWidget({widgetId: '{$widgetId}'}).init();
JS);
?>
<div id="<?= $widgetId ?>" data-widget_id="<?= $widgetId ?>" class="dropdown dropdown-inline" data-toggle="tooltip" title="" data-placement="top" data-original-title="" style="float: right;margin-right: -8px;"> 
    <a href="#!" class="btn btn-fixed-height btn-bg-white btn-text-dark-50 btn-hover-text-primary btn-icon-primary font-weight-bolder font-size-sm  mr-3 btn-sm _filter_columns"  aria-haspopup="true" aria-expanded="false" style="border: 1px solid #ccc;" data-toggle="dropdown">
        <span class="svg-icon svg-icon-md">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect x="0" y="0" width="24" height="24"></rect>
                    <path d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z" fill="#000000"></path>
                </g>
            </svg><!--end::Svg Icon-->
        </span>
        <?= $title ?>
    </a>
    <div data-widget_id="<?= $widgetId ?>" class="dropdown-menu dropdown-menu-sm dropdown-menu-right p-0 m-0" style="">
        <!--begin::Navigation-->
        <?= Html::beginForm(['user-meta/filter'], 'post',  [
            'style' => 'max-height: 56vh; overflow: auto;',
            'class' => "app-scroll"
        ]); ?>
            <?= Html::activeInput('hidden', $model, 'table_name', [
                'value' => App::tableName($searchModel, false)
            ]) ?>
            <ul class="navi navi-hover" style="padding: 10px;">
                <li class="navi-item"> 
                    <div class="checkbox-list ">
                        <label class="checkbox ">
                            <input type="checkbox" class="check-all-filter">
                            <span></span>
                            CHECK ALL
                        </label>
                    </div>
                    <hr>
                </li>
                <li class="navi-item">
                    <div class="checkbox-list">
                        <?= Html::foreach($searchModel->tableColumns, function($value, $key) use ($model, $filterColumns) {
                            return '<label class="checkbox">
                                '. Html::activeInput('checkbox', $model, 'columns[]', [
                                    'value' => $key,
                                    'class' => '_filter_column_checkbox',
                                    'data-key' => $key,
                                    'checked' => in_array($key,  $filterColumns)
                                ]) .'
                                <span></span>
                                '. Inflector::humanize(strtoupper($key)) .'
                            </label>';
                        }) ?>
                    </div>
                </li>
            </ul>
        <?= Html::endForm(); ?> 
        <!--end::Navigation-->
    </div>
</div>