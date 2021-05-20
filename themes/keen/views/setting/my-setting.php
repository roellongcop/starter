<?php

use app\helpers\App;
use app\models\search\ThemeSearch;
use app\widgets\AnchorForm;
use app\widgets\BootstrapSelect;
use app\widgets\ThemeView;
use app\widgets\KeenActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Ip */

$this->title = "My Settings";
// $this->params['breadcrumbs'][] = ['label' => 'Setting', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $user->username, 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = 'My Settings';
$this->params['searchModel'] = new ThemeSearch();

?>

<div>
	<?php $form = KeenActiveForm::begin(); ?>
		
		<div class="form-group">
			<?= AnchorForm::widget() ?>
		</div>
	<?php KeenActiveForm::end(); ?>

	<div class="row">
		<?php foreach ($themes as $theme): ?>
			<div class="col-md-3">
            	<?= ThemeView::widget([
            		'theme' => $theme
            	]) ?>
            </div>
        <?php endforeach ?>
	</div>
</div>