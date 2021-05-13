<?php

use app\helpers\App;
use app\widgets\Anchor;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
$this->registerJs(<<<SCRIPT
$('.theme-image').on('change', function() {

	var input = this;

    var imageInput = input.files[0]; 
    var id = $(input).parents('div.image-input')
    	.find('input.theme_id')
    	.val()


    let formData = new FormData();
    formData.append('Theme[imageInput]', imageInput);
    formData.append('Theme[id]', id);

	$.ajax( {
		url: '{$uploadUrl}',
		type: 'POST',
		data: formData,
		dataType: 'text',
		processData: false,
		contentType: false,
		success: function(s) {
			$(input).parents('div.image-input')
            	.find('img.img-thumbnail')
            	.attr('src', s)
		},
		error: function(e) {
			alert(e.responseText)
		}
	});
})
SCRIPT, \yii\web\View::POS_END)
?>

<div class="card card-custom gutter-b card-stretch" style="border: 1px solid <?= ($theme->id == $currentTheme->id)? '#1BC5BD': '#ccc;' ?>">
	<!--begin::Header-->
	<div class="card-header border-0 pt-6 p11">
		<h3 class="card-title align-items-start flex-column">
			<span class="card-label font-weight-bolder font-size-h4 text-dark-75">
				<?= $theme->name ?>
			</span>
			<small><?= $theme->description ?></small>
		</h3>
	</div>
	<!--end::Header-->
	<!--begin::Body-->
	<div class="card-body">
		<!--begin::Container-->
		<div class="pt-1">
			<!--begin::Image--> 
			<div class="image-input">
				<img src="<?= $theme->imagePath ?>&w=300" class="img-thumbnail theme-image">
				<?php if (App::identity()->can('change-image', 'theme')): ?>
					<?php $form = ActiveForm::begin(); ?>
	              		<?= $form->field($theme, 'id')
	              			->hiddenInput(['class' => 'theme_id'])
	              			->label(false) ?>
						<label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" 
							data-action="change" 
							data-toggle="tooltip" 
							title="" 
							data-original-title="Change Image">
							<i class="fa fa-pen icon-sm text-muted"></i>
							<?= $form->field($theme, 'imageInput')
								->fileInput(['class' => 'theme-image'])
								->label(false) ?>
						</label>
					<?php ActiveForm::end(); ?>
				<?php else: ?>
					<p></p>
				<?php endif ?>
			</div>
			<!--end::Image-->
			<p class="text-dark-75 font-size-lg font-weight-normal pt-3 mb-4">

			</p>
			<?= Anchor::widget([
				'title' => 'Activate',
				'link' => ['theme/activate', 'slug' => $theme->slug],
				'options' => [
					'class' => 'btn btn-sm btn-primary font-weight-bolder py-2',
					'data-method' => 'post',
					'data-confirm' => 'Are you sure ?'
				]
			]) ?>
			<?= Html::a('View', $theme->imagePath, [
				'target' => '_blank',
				'class' => 'btn btn-sm btn-secondary font-weight-bolder py-2',
			]) ?>
		</div>
		<!--end::Container-->
	</div>
	<!--end::Body-->
</div>