<?php

use app\helpers\App;
use app\widgets\Anchor;
use app\widgets\Detail;
use yii\helpers\Inflector;
?>
<?php if (($models = $dataProvider->models) != null): ?>
<hr>
<p class="lead">
	<?= Inflector::pluralize($nameModule) ?> 
	(<?= number_format($dataProvider->totalCount) ?>)

	&nbsp;
	<?= Anchor::widget([
		'title' => 'View in ' . Inflector::pluralize($nameModule) . ' Page',
		'link' => [$controller . '/index', "keywords" => $searchModel->keywords],
		'options' => ['class' => 'btn btn-success btn-sm']
	]) ?>
</p>

<div class="accordion accordion-light accordion-toggle-arrow" id="<?= $module ?>">

	<?php foreach ($models as $key => $model): ?>
		
		<div class="card">
			<div class="card-header" id="headingOne2">
				<div class="card-title collapsed" 
					data-toggle="collapse" 
					data-target="#<?= $module ?>-tab-<?= $model->id ?>" 
					aria-expanded="false">
					<?= $key + 1 ?>) 
					<button type="button"><?= $model->mainAttribute ?></button>
					(<?= App::formatter('asFulldate', $model->created_at) ?>)
				</div>
			</div>
			<div id="<?= $module ?>-tab-<?= $model->id ?>" class="collapse" data-parent="#<?= $module ?>" style="">
				<div class="card-body">
					<p>
						<?= Anchor::widget([
							'title' => 'View Details',
							'link' => $model->viewUrl,
							'options' => ['class' => 'btn btn-info btn-sm']
						]) ?>
					</p>
					<?= Detail::widget(['model' => $model]) ?>
				</div>
			</div>
		</div>
	<?php endforeach ?>
</div>
<?php endif ?>