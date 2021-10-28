<?php

use app\models\search\ThemeSearch;
use app\widgets\AnchorForm;
use app\widgets\ThemeView;
use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Ip */

$this->title = "My Settings";
$this->params['breadcrumbs'][] = 'My Settings';
$this->params['searchModel'] = new ThemeSearch();
?>
<div class="setting-my-setting-page">
	<?php $form = ActiveForm::begin(['id' => 'setting-my-setting-form']); ?>
		<div class="form-group">
			<?= AnchorForm::widget() ?>
		</div>
	<?php ActiveForm::end(); ?>
	<div class="row">
		<?= Html::foreach($themes, function($key, $theme) {
			return '<div class="col-md-3">
            	'. ThemeView::widget(['theme' => $theme]) .'
            </div>';
		}) ?>
	</div>
</div>