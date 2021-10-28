<?php

use app\widgets\AnchorForm;
use app\helpers\Html;
?>
<div>
	<div class="alert alert-custom alert-light-primary fade show mb-5" role="alert" style="padding: 0.5rem 2rem;">
		<div class="alert-icon">
			<i class="flaticon-warning"></i>
		</div>
		<div class="alert-text">
			You are going to "<?= $process ?>" 
			<?=  number_format((is_countable($models)? count($models): 0)) ?> data.
		</div>
		<div class="alert-close">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">
					<i class="ki ki-close"></i>
				</span>
			</button>
		</div>
	</div>
	<?= Html::beginForm(['confirm-action'], 'post') ?>
		<?= (count($models) > 10)? AnchorForm::widget() . '<hr>': '' ?>
		<input type="hidden" name="process-selected" value="<?= $post['process-selected'] ?>">
		<div class="accordion accordion-light accordion-light-borderless accordion-svg-toggle" 
			id="accordionContent-<?= $widgetId ?>">
			<?= Html::foreach($models, function($key, $model) {
				return $this->render('_card', [
					'key' => $key,
					'model' => $model,
					'post' => $post,
				]);
			}) ?>
		</div>
		<hr>
		<?= AnchorForm::widget(['submitLabel' => 'Confirm']) ?>
	<?= Html::endForm() ?> 
</div>