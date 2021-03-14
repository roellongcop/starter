<?php

use app\helpers\App;
use app\widgets\AnchorForm;
use app\widgets\RecordStatusInput;
use app\widgets\Checkbox;
use app\widgets\KeenActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Backup */
/* @var $form yii\widgets\ActiveForm */

$tables = App::component('general')->getAllTables();

$this->registerJs(<<< SCRIPT
$('.all-table-checkbox').on('click', function() {
    var is_checked = $(this).is(':checked');

    if(is_checked) {
        $('input[name="Backup[tables][]"]').prop('checked', true);
    }
    else {
        $('input[name="Backup[tables][]"]').prop('checked', false);
    } 
})
SCRIPT, \yii\web\View::POS_END);
?>


    <?php $form = KeenActiveForm::begin(); ?>

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
            ]) ?>
        </div>

    </div>
    <div class="form-group">
		<?= AnchorForm::widget() ?>
    </div>

    <?php KeenActiveForm::end(); ?>

