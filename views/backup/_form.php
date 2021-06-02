<?php

use app\helpers\App;
use app\widgets\AnchorForm;
use app\widgets\RecordStatusInput;
use app\widgets\Checkbox;
use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Backup */
/* @var $form app\widgets\ActiveForm */

$tables = App::component('general')->getAllTables();
$registerJs = <<< SCRIPT
$('.all-table-checkbox').on('click', function() {
    var is_checked = $(this).is(':checked');

    if(is_checked) {
        $('input[name="Backup[tables][]"]').prop('checked', true);
    }
    else {
        $('input[name="Backup[tables][]"]').prop('checked', false);
    } 
})
SCRIPT;

$this->registerJs($registerJs, \yii\web\View::POS_END);
?>
    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-5">
            <?= $form->field($model, 'filename')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

            <?= RecordStatusInput::widget([
                'model' => $model,
                'form' => $form,
            ]) ?>
        </div>
        <div class="col-md-7">
            <div class="checkbox-list">
                <label class="checkbox">
                    <input class="checkbox all-table-checkbox" type="checkbox">
                    <span></span>
                    TABLES
                </label>
            </div>
            <hr>
            <?= Checkbox::widget([
                'data' => $tables,
                'name' => 'Backup[tables][]',
                'checkedFunction' => function($key, $value) use ($model) {
                    return $model->tables && in_array($key, $model->tables)? 'checked': '';
                }
            ]) ?>
        </div>

    </div>
    <div class="form-group">
        <?= AnchorForm::widget() ?>
    </div>

    <?php ActiveForm::end(); ?>

