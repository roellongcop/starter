<?php

use app\models\search\UserSearch;
use app\widgets\AnchorForm;
use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Ip */

$this->title = "Profile : {$user->username}";
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->username, 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new UserSearch();
?>

<div>
	<?php $form = ActiveForm::begin(); ?>
		<div class="row">
			<div class="col-md-5">
				<?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
				<?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
			</div>
		</div>
		<div class="form-group">
			<?= AnchorForm::widget() ?>
		</div>
	<?php ActiveForm::end(); ?>
</div>