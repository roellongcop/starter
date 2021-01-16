<?php

use app\helpers\App;
use app\widgets\AnchorForm;
use app\widgets\BootstrapSelect;
use app\widgets\Checkbox;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Backup */
/* @var $form yii\widgets\ActiveForm */

$tables = App::component('general')->getAllTables()
?>
    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-5">
            <?= $form->field($model, 'filename')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

            <?= BootstrapSelect::widget([
                'attribute' => 'record_status',
                'searchable' => false,
                'model' => $model,
                'form' => $form,
                'data' => App::mapParams('record_status'),
            ]) ?>
        </div>
        <div class="col-md-7">
            <label>TABLES</label> 
            <?= Checkbox::widget([
                'data' => $tables,
                'name' => 'Backup[tables][]',
            ]) ?>
        </div>

    </div>
    <div class="form-group">
        <?= AnchorForm::widget() ?>
    </div>

    <?php ActiveForm::end(); ?>

