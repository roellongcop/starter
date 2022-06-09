<?php

use app\helpers\App;
use app\helpers\Html;
use app\widgets\AppIcon;
use app\widgets\Detail;
?>
<div class="card">
	<div class="card-header" id="heading<?= $model->id ?>">
		<div class="card-title collapsed" data-toggle="collapse" data-target="#collapse-action-<?= $model->id ?>">
			<?= AppIcon::widget(['icon' => 'double_angle_left']) ?>
			<?= number_format(($key + 1)) ?>. 
			<div class="card-label pl-4">
				<?= $model->mainAttribute ?>
			</div>
			<span>
				<?= Html::ifElse(
					App::modelBeforeCan($model, $post['process-selected']),
					"<input type='hidden' name='selection[]' value='{$model->id}'>
					<span class='badge badge-success'>Applicable</span>",
					'<span class="badge badge-danger">Not Applicable</span>'
				) ?>
			</span>
		</div>
	</div>
	<div id="collapse-action-<?= $model->id ?>" class="collapse" data-parent="#accordionContent-<?= $widgetId ?>">
		<div class="card-body pl-12">
			<?= $model->detailView ?>
		</div>
	</div>
</div>