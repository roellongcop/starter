<?php

use app\helpers\App;
use app\widgets\Anchor;
use app\widgets\Detail;
?>
<div class="card">
	<div class="card-header" id="headingOne2">
		<div class="card-title collapsed" 
			data-toggle="collapse" 
			data-target="#<?= $module ?>-tab-<?= $model->id ?>" 
			aria-expanded="false">
			<?= $index + 1 ?>) 
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