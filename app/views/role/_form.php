<?php

use app\helpers\App;
use app\widgets\AnchorForm;
use app\widgets\RecordStatusInput;
use yii\widgets\ActiveForm;
$controller_actions = App::component('access')->controllerActions();

/* @var $this yii\web\View */
/* @var $model app\models\Role */
/* @var $form yii\widgets\ActiveForm */
?>


<?php $form = ActiveForm::begin(); ?>
 

    <div class="form-group">
        <?= AnchorForm::widget() ?>
    </div>

    <ul class="nav nav-tabs">
      <li class="active"><a data-toggle="tab" href="#_main_form">Name</a></li>
      <li><a data-toggle="tab" href="#_form_role_access">Role Access</a></li>
      <li><a data-toggle="tab" href="#_form_navigation">Navigation</a></li>
      <li><a data-toggle="tab" href="#_form_actions">Module Access</a></li>
    </ul>

    <div class="tab-content">
        <div id="_main_form" class="tab-pane fade in active">
            <div class="row">
                <div class="col-md-5">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    <?= RecordStatusInput::widget([
                        'model' => $model,
                        'form' => $form,
                    ]) ?>
                </div>
            </div>
        </div>
        <div id="_form_role_access" class="tab-pane fade">
            <?= $this->render('_form_role_access', [
                'model' => $model
            ]) ?>
        </div>
        <div id="_form_navigation" class="tab-pane fade">
            <?= $this->render('_form_navigation', [
                'controller_actions' => $controller_actions,
                'model' => $model
            ]) ?>
        </div>
        <div id="_form_actions" class="tab-pane fade">
            <?= $this->render('_form_actions', [
                'controller_actions' => $controller_actions,
                'model' => $model
            ]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= AnchorForm::widget() ?>
    </div>

<?php ActiveForm::end(); ?>
