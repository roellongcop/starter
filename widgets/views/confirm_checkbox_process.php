<?php

use app\helpers\App;
use app\widgets\AnchorForm;
use app\widgets\Detail;
use yii\helpers\Html;

?>
<div>
	<div class="alert alert-custom alert-light-primary fade show mb-5" role="alert" style="padding: 0.5rem 2rem;">
		<div class="alert-icon">
			<i class="flaticon-warning"></i>
		</div>
		<div class="alert-text">
			You are going to "<?= $process ?>" 
			<?=  number_format(count($models)) ?> data.
		</div>
		<div class="alert-close">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">
					<i class="ki ki-close"></i>
				</span>
			</button>
		</div>
	</div>

	<?= Html::beginForm(['process-checkbox'], 'post') ?>
		<?= (count($models) > 10)? AnchorForm::widget() . '<hr>': '' ?>

		<input type="hidden" 
			name="process-selected" 
			value="<?= $post['process-selected'] ?>">

		<div class="accordion accordion-light accordion-light-borderless accordion-svg-toggle" 
			id="accordionContent">
			<?php foreach ($models as $key => $model): ?>
				<div class="card">
					<div class="card-header" id="heading<?= $model->id ?>">
						<div class="card-title collapsed" 
							data-toggle="collapse" 
							data-target="#collapse-action-<?= $model->id ?>">

							<div class="card-label pl-4">
								<?= number_format(($key + 1)) ?>. 
								<button type="button">
									<?= $model->mainAttribute ?>
								</button>
								<span>
									<?php if (App::modelCan($model, $post['process-selected'])): ?>
										<input type="hidden" 
											name="selection[]" 
											value="<?= $model->id ?>">
										<span class="label label-success">Applicable</span>
									<?php else: ?>
										<span class="label label-danger">Not Applicable</span>
									<?php endif ?>
								</span>
							</div>
						</div>
					</div>
					<div id="collapse-action-<?= $model->id ?>" 
							class="collapse" 
							data-parent="#accordionContent">
						<div class="card-body pl-12">
							<?= Detail::widget(['model' => $model]) ?>
						</div>
					</div>
				</div>
			<?php endforeach ?>
		</div>
		<hr>
		<?= AnchorForm::widget() ?>
	<?= Html::endForm() ?> 
</div>
 