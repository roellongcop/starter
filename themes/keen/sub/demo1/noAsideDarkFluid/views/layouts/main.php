<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\helpers\App;
use app\helpers\Url;
use app\themes\keen\assets\KeenAsset;
use app\themes\keen\sub\demo1\noAsideDark\assets\KeenDemo1NoAsideDarkAppAsset;
use app\widgets\Alert;
use app\helpers\Html;

KeenDemo1NoAsideDarkAppAsset::register($this);
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
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="quick-panel-right demo-panel-right offcanvas-right header-fixed header-mobile-fixed subheader-enabled page-loading">
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
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Subheader-->
						<?= $this->render('_sub_header') ?>
						<!--end::Subheader-->
						<!--begin::Entry-->
						<div class="d-flex flex-column-fluid">
							<!--begin::Container-->
				        	<div class="container-fluid">
					            <div class="row">
					                <div class="col-xl-12">
					                    <?= Alert::widget() ?>
					                    <?= Html::content($content, $this->params) ?>
				                	</div>
				            	</div>
							</div>
							<!--end::Container-->
						</div>
						<!--end::Entry-->
					</div>
					<!--end::Content-->
					<!--begin::Footer-->
					<div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
						<!--begin::Container-->
						<div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
							<!--begin::Copyright-->
							<div class="text-dark order-2 order-md-1">
								<span class="text-muted font-weight-bold mr-2">2020©</span>
								<a href="https://keenthemes.com/keen" target="_blank" class="text-dark-75 text-hover-primary">Keenthemes</a>
							</div>
							<!--end::Copyright-->
							<!--begin::Nav-->
							<div class="nav nav-dark">
								<a href="https://keenthemes.com/keen" target="_blank" class="nav-link pl-0 pr-2">About</a>
								<a href="https://keenthemes.com/keen" target="_blank" class="nav-link pr-2">Team</a>
								<a href="https://keenthemes.com/keen" target="_blank" class="nav-link pr-0">Contact</a>
							</div>
							<!--end::Nav-->
						</div>
						<!--end::Container-->
					</div>
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
		<?= $this->render('_quick_panel_canvas') ?>
		<!--end::Quick Panel-->
		<!--begin::Chat Panel-->
		<?php # $this->render('_chat_panel') ?>
		<!--end::Chat Panel-->
		<!--begin::Scrolltop-->
		<?= $this->render('_scroll_top') ?>
		<!--end::Scrolltop-->
		<script>var HOST_URL = "https://preview.keenthemes.com/keen/theme/tools/preview";</script>
	    <!--begin::Global Config(global config for global JS scripts)-->
	    <script>
		    var KTAppSettings = { 
			    "breakpoints": { 
			    	"sm": 576, 
			    	"md": 768, 
			    	"lg": 992, 
			    	"xl": 1200, 
			    	"xxl": 1400 
			    }, 
				"colors": { 
					"theme": { 
						"base": { 
							"white": "#ffffff", 
							"primary": "#3E97FF", 
							"secondary": "#E5EAEE", 
							"success": "#08D1AD", 
							"info": "#844AFF", 
							"warning": "#F5CE01", 
							"danger": "#FF3D60", 
							"light": "#E4E6EF", 
							"dark": "#181C32" 
						}, 
						"light": {
							"white": "#ffffff", 
							"primary": "#DEEDFF", 
							"secondary": "#EBEDF3", 
							"success": "#D6FBF4", 
							"info": "#6125E1", 
							"warning": "#FFF4DE", 
							"danger": "#FFE2E5", 
							"light": "#F3F6F9", 
							"dark": "#D6D6E0" 
						}, 
						"inverse": { 
							"white": "#ffffff", 
							"primary": "#ffffff", 
							"secondary": "#3F4254", 
							"success": "#ffffff", 
							"info": "#ffffff", 
							"warning": "#ffffff", 
							"danger": "#ffffff", 
							"light": "#464E5F", 
							"dark": "#ffffff" 
						} 
					}, 
					"gray": { 
						"gray-100": "#F3F6F9", 
						"gray-200": "#EBEDF3", 
						"gray-300": "#E4E6EF", 
						"gray-400": "#D1D3E0", 
						"gray-500": "#B5B5C3", 
						"gray-600": "#7E8299", 
						"gray-700": "#5E6278", 
						"gray-800": "#3F4254", 
						"gray-900": "#181C32" 
					} 
				}, 
				"font-family": "Poppins" 
			};
		</script>
		<!--end::Global Config-->
		<!--end::Body-->
	<?php $this->endBody() ?>
	</body>
</html>
<?php $this->endPage() ?>