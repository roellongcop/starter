<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\helpers\App;
use app\helpers\Html;
use app\helpers\Url;
use app\themes\keen\assets\KeenAsset;
use app\themes\keen\sub\demo3\fixed\assets\KeenDemo3FixedAppAsset;
use app\widgets\Alert;
use app\widgets\AnchorBack;
use app\widgets\Anchors;
use app\widgets\Breadcrumbs;
use app\widgets\ExportButton;

AppAsset::register($this);
KeenAsset::register($this);
KeenDemo3FixedAppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="<?= Url::image(App::setting('image')->favicon, ['w' => 16]) ?>" type="image/x-icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?> 
</head>
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled page-loading">
<?php $this->beginBody() ?>
	<!--begin::Main-->
	<!--begin::Header Mobile-->
	<?= $this->render('_header_mobile') ?>
	<!--end::Header Mobile-->
	<div class="d-flex flex-column flex-root">
		<!--begin::Page-->
		<div class="d-flex flex-row flex-column-fluid page">
			<!--begin::Wrapper-->
			<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
				<!--begin::Header-->
				<?= $this->render('_header') ?>
				<!--end::Header-->
				<!--begin::Subheader-->
				<?= $this->render('_sub_header') ?>
				<!--end::Subheader-->
				<!--begin::Content-->
				<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
					<div class="gutter-b" id="kt_breadcrumbs">
						<div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
							<!--begin::Info-->
							<div class="d-flex align-items-center flex-wrap mr-1">
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
								<div class="d-flex align-items-baseline flex-wrap mr-5">
									<!--begin::Page Title-->
									<h4 class="text-dark font-weight-bold my-1 mr-5">
										<?= $this->title ?>
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
					                        'class' => 'breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm',
					                    ],
					                    'itemTemplate' => "<li class='breadcrumb-item'>{link}</li>\n",
					                    'activeItemTemplate' => "<li class=\"breadcrumb-item\">{link}</li>\n",
					                    'anchorClass' => 'text-dark-50'
					                ]); ?>
									<!--end::Breadcrumb-->
								</div>
								<!--end::Page Heading-->
							</div>
							<!--end::Info-->
							<!--begin::Toolbar-->
							<div class="d-flex align-items-center">
								<!--begin::Dropdown-->
					            <?= Html::exportButton($this->params) ?>
            					<?= Html::createButton($this->params) ?>
							</div>
							<!--end::Toolbar-->
						</div>
					</div>
					<!--begin::Entry-->
					<div class="d-flex flex-column-fluid">
						<!--begin::Container-->
						<div class="container">
							<?= Alert::widget() ?>
							<?= Html::content($content, $this->params) ?>
						</div>
						<!--end::Container-->
					</div>
					<!--end::Entry-->
				</div>
				<!--end::Content-->
				<!--begin::Footer-->
				<?= $this->render('_footer') ?>
				<!--end::Footer-->
			</div>
			<!--end::Wrapper-->
		</div>
		<!--end::Page-->
	</div>
	<!--end::Main-->
	<!-- begin::User Panel-->
	<?= $this->render('_user_panel') ?>
	<!-- end::User Panel-->
	<!--begin::Quick Panel-->
	<?= $this->render('_quick_panel') ?>
	<!--end::Quick Panel-->
	<!--begin::Chat Panel-->
	<?php # $this->render('_chat_panel') ?>
	<!--end::Chat Panel-->
	<!--begin::Scrolltop-->
	<?= $this->render('_scroll_top') ?>
	<!--end::Scrolltop-->
	<!--begin::Sticky Toolbar-->
	<?= $this->render('_sticky_toolbar') ?>
	<!--end::Sticky Toolbar-->
	<!--begin::Demo Panel-->
	<?php # $this->render('_demo_panel') ?>
	<!--end::Demo Panel-->
	<script>var HOST_URL = "https://preview.keenthemes.com/keen/theme/tools/preview";</script>
	<!--begin::Global Config(global config for global JS scripts)-->
	<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#8950FC", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
	<!--end::Global Config-->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>