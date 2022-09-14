<?php

use app\helpers\Html;
use app\models\Setting;
use app\models\search\SettingSearch;
use app\widgets\Anchor;

/* @var $this yii\web\View */
/* @var $model app\models\Ip */
$setting_modules = Setting::MODULE;

$this->title = 'General Settings';
$this->params['breadcrumbs'][] = 'Set Up';
$this->params['breadcrumbs'][] = $setting_modules[$tab]['label'];
$this->params['searchModel'] = new SettingSearch();
$this->params['activeMenuLink'] = '/setting/general';
?>
<div class="setting-general-page">
	<p>
		<?= Anchor::widget([
			'title' => 'Reset Settings',
			'link' => ['reset'],
			'options' => [
				'class' => 'btn btn-danger',
				'data-method' => 'post',
				'data-confirm' => 'Reset Settings?'
			]
		]) ?>
	</p>
	<div class="row">
		<div class="col-md-3">
			<ul class="navi navi-accent navi-hover navi-bold navi-border">
				<?= Html::foreach($setting_modules, function($menu, $keyTab) use ($tab) {
					return $this->render('_general-navigation', [
						'tab' => $tab,
						'keyTab' => $keyTab,
						'menu' => $menu,
					]);
				}) ?>
			</ul>
		</div>
		<div class="col-md-9" style="border-left: 1px solid #ddd">
			<?= $this->render("general/{$tab}", ['model' => $model]) ?>
		</div>
	</div>
</div>