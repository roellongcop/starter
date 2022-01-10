<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\helpers\App;
use app\helpers\Url;
use app\themes\keen\assets\KeenAsset;
use app\themes\keen\sub\demo2\fixed\assets\KeenDemo2FixedAppAsset;
use app\widgets\Alert;
use app\helpers\Html;

KeenDemo2FixedAppAsset::register($this);
KeenAsset::register($this);
AppAsset::register($this);
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
<body id="kt_body" data-sidebar="on" class="header-fixed header-mobile-fixed subheader-enabled sidebar-enabled page-loading">
<?php $this->beginBody() ?>
	<!--begin::Main-->
	<!--begin::Header Mobile-->
	<?= $this->render('_header_mobile') ?>
	<!--end::Header Mobile-->
	<!--begin::Aside Offcanvas-->
	<?= $this->render('_aside_offcanvas') ?>
	<!--end::Aside Offcanvas-->
	<div class="d-flex flex-column flex-root">
		<!--begin::Page-->
		<div class="d-flex flex-row flex-column-fluid page">
			<!--begin::Aside-->
			<?= $this->render('_aside') ?>
			<!--end::Aside-->
			<!--begin::Wrapper-->
			<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
				<!--begin::Content-->
				<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
					<!--begin::Subheader-->
					<?= $this->render('_sub_header') ?>
					<!--end::Subheader-->
					<!--begin::Entry-->
					<div class="d-flex flex-column-fluid">
						<!--begin::Container-->
						<div class="container">
							<!--begin::Dashboard-->
							<!--begin::Table Widget 6-->
							<?= Alert::widget() ?>
							<?= Html::content($content, $this->params) ?>
							<!--end::Table Widget 6-->
							<!--end::Dashboard-->
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
			<!--begin::Sidebar-->
			<?= $this->render('_sidebar') ?>
			<!--end::Sidebar-->
		</div>
		<!--end::Page-->
	</div>
	<!--end::Main-->
	<!-- begin::Notifications Panel-->
	<?php # $this->render('_notifications_panel') ?>
	<!-- end::Notifications Panel-->
	<!--begin::Quick Actions Panel-->
	<?php # $this->render('_quick_actions_panel') ?>
	<!--end::Quick Actions Panel-->
	<!-- begin::User Panel-->
	<?php # $this->render('_user_panel') ?>
	<!-- end::User Panel-->
	<!--begin::Quick Panel-->
	<?php # $this->render('_quick_panel') ?>
	<!--end::Quick Panel-->
	<!--begin::Chat Panel-->
	<?php # $this->render('_chat_panel') ?>
	<!--end::Chat Panel-->
	<!--begin::Scrolltop-->
	<?= $this->render('_scroll_top') ?>
	<!--end::Scrolltop-->
	<!--begin::Sticky Toolbar-->
	<?php # $this->render('_sticky_toolbar') ?>
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