<?php
use app\models\search\UserSearch;
use app\widgets\AnchorForm;
use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Ip */

$this->title = 'Profile: ' . $user->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->mainAttribute, 'url' => $user->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new UserSearch();
?>
<div class="user-profile-page">
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