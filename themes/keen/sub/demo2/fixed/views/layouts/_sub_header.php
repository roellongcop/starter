<?php

use app\helpers\App;
use app\helpers\Html;
use app\widgets\AnchorBack;
use app\widgets\Breadcrumbs;
use app\widgets\ExportButton;
?>
<div class="subheader py-4 pt-lg-0 pb-lg-10" id="kt_subheader">
	<div class="container d-flex align-items-center justify-content-between flex-wrap">
		<!--begin::Info-->
		<div class="d-flex align-items-center py-2 mr-1">
			<!--begin::Aside Offcanvas Toggle-->
			<button class="btn btn-icon btn-hover-icon-primary mr-1 pl-0 justify-content-start d-none d-lg-flex" id="kt_aside_offcanvas_toggle">
				<span class="svg-icon svg-icon-2x">
					<!--begin::Svg Icon | path:assets/media/svg/icons/Text/Toggle-Right.svg-->
					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
							<rect x="0" y="0" width="24" height="24" />
							<path fill-rule="evenodd" clip-rule="evenodd" d="M22 11.5C22 12.3284 21.3284 13 20.5 13H3.5C2.6716 13 2 12.3284 2 11.5C2 10.6716 2.6716 10 3.5 10H20.5C21.3284 10 22 10.6716 22 11.5Z" fill="black" />
							<path opacity="0.5" fill-rule="evenodd" clip-rule="evenodd" d="M14.5 20C15.3284 20 16 19.3284 16 18.5C16 17.6716 15.3284 17 14.5 17H3.5C2.6716 17 2 17.6716 2 18.5C2 19.3284 2.6716 20 3.5 20H14.5ZM8.5 6C9.3284 6 10 5.32843 10 4.5C10 3.67157 9.3284 3 8.5 3H3.5C2.6716 3 2 3.67157 2 4.5C2 5.32843 2.6716 6 3.5 6H8.5Z" fill="black" />
						</g>
					</svg>
					<!--end::Svg Icon-->
				</span>

			</button>
			<!--end::Aside Offcanvas Toggle-->
			<!--begin::Page Heading-->
			<div class="d-flex flex-column mr-5">
				<?= AnchorBack::widget([
	                'title' => '<i class="fa fa-angle-left"></i>',
	                'tooltip' => 'Go Back',
	                'options' => [
	                    'class' => 'btn btn-secondary tbn-sm',
	                    'data-original-title' => 'Go back',
	                    'data-toggle' => "tooltip",
	                    'data-theme' => "dark",
	                ]
	            ]) ?>
			</div>
			<div class="d-flex flex-column mr-5">

				<!--begin::Page Title-->
				<h4 class="text-dark font-weight-bold py-1 mr-5 my-0"> 
					<?= $this->title ?>
					<!-- <small class="text-muted">updates and statistics</small> -->
				</h4>
				<!--end::Page Title-->

				<!--begin::Breadcrumb-->
				<?= Breadcrumbs::widget([
                    'homeLink' => [
                        'label' => 'Dashboard',
                        'url' => ['dashboard/index']
                    ],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    'options' => [
                        'class' => 'breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 m-0 font-size-sm',
                    ],
                    'itemTemplate' => "<li class='breadcrumb-item'>{link}</li>\n",
                    'activeItemTemplate' => "<li class=\"breadcrumb-item\">{link}</li>\n",
                    'anchorClass' => 'text-muted'
                ]); ?>
				<!--end::Breadcrumb-->
			</div>

			<!--end::Page Heading-->
		</div>

		<!--end::Info-->
		<!--begin::Toolbar-->
		<div class="d-flex align-items-center flex-wrap py-2">
			<!--begin::Dropdown-->
            <?= Html::exportButton($this->params) ?>
            <?= Html::createButton($this->params) ?>
		</div>
		<!--end::Toolbar-->
	</div>

</div>