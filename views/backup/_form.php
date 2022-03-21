<?php

use app\helpers\App;
use app\widgets\Checkbox;
use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Backup */
/* @var $form app\widgets\ActiveForm */

$tables = App::component('general')->getAllTables();

$this->registerJs(<<< JS
    $('.all-table-checkbox').on('click', function() {
        let is_checked = $(this).is(':checked');
        if(is_checked) {
            $('input[name="Backup[tables][]"]').prop('checked', true);
        }
        else {
            $('input[name="Backup[tables][]"]').prop('checked', false);
        } 
    });
JS);
?>
<?php $form = ActiveForm::begin(['id' => 'backup-form']); ?>
    <div class="row">
        <div class="col-md-5">
            <?= $form->field($model, 'filename')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

            <?= ActiveForm::recordStatus([
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
            <br>
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
        <?= ActiveForm::buttons() ?>
    </div>
<?php ActiveForm::end(); ?>