<?php

use app\helpers\App;
use app\helpers\Url;
use app\models\search\DashboardSearch;
use app\widgets\Anchor;

/* @var $this yii\web\View */
/* @var $model app\models\Ip */

$this->title = 'General Settings';
// $this->params['breadcrumbs'][] = ['label' => 'Ips', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Set Up';
$this->params['searchModel'] = new DashboardSearch();

$menus = [
    'general' => ['label' => 'General', 'icon' => '<i class="fas fa-cog"></i>'],
    'email' => ['label' => 'Email', 'icon' => '<i class="far fa-envelope"></i>'],
    'image' => ['label' => 'Image', 'icon' => '<i class="far fa-file-image"></i>'],
];
?>

<div>
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
				<?php foreach ($menus as $keyTab => $menu): ?>
					<li class="navi-item">
				        <a class="navi-link <?= ($keyTab == $tab)? 'active': '' ?>" href="<?= Url::to(['setting/general', 'tab' => $keyTab]) ?>">
				            <span class="navi-icon">
				            	<?= $menu['icon'] ?>
				            </span>
				            <span class="navi-text">
				            	<?= $menu['label'] ?>
				            </span>
				        </a>
				    </li>
				<?php endforeach ?>
			</ul>
		</div>
		<div class="col-md-9" style="border-left: 1px solid #ddd">
			<?= $this->render("general/{$tab}", ['model' => $model]) ?>
		</div>
	</div>
</div>