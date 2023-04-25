<?php

use app\helpers\App;
use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Backup */
/* @var $form app\widgets\ActiveForm */

$this->addJsFile('js/backup-form');
?>
<?php $form = ActiveForm::begin(['id' => 'backup-form']); ?>
    <div class="row">
        <div class="col-md-5">
            <?= $form->field($model, 'filename')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

            <?= $form->recordStatus($model) ?>
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
            <?= $form->checkbox(
                App::component('general')->getAllTables(), 
                'Backup[tables][]', 
                fn($key, $value) => $model->tables && in_array($key, $model->tables)? 'checked': ''
            ) ?>
          
        </div>
    </div>
    <div class="form-group">
        <?= $form->buttons() ?>
    </div>
<?php ActiveForm::end(); ?>