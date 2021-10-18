<?php

use app\helpers\App;
use app\widgets\Anchor;
use app\helpers\Html;
use app\helpers\Url;
use app\widgets\ActiveForm;
?>
<div id="container-<?= $id ?>" class="card card-custom gutter-b card-stretch" style="border: 1px solid <?= ($theme->id == $currentTheme->id)? '#1BC5BD': '#ccc;' ?>">
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
				<?= $theme->getPreviewImage(['w' => 300], [
					'class' => 'img-thumbnail theme-image'
				]) ?>
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
			<?= Html::a('Preview', Url::current(['preview-theme' => $theme->slug]), [
				'target' => '_blank',
				'class' => 'btn btn-sm btn-secondary font-weight-bolder py-2',
			]) ?>
		</div>
		<!--end::Container-->
	</div>
	<!--end::Body-->
</div>