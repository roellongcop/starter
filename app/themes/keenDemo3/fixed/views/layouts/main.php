<?php

/* @var $this \yii\web\View */
/* @var $content string */


use app\assets\AppAsset as StarterAppAsset;
use app\models\search\SettingSearch;
use app\themes\keenDemo3\fixed\assets\AppAsset;
use app\widgets\Alert;
use yii\helpers\Html;


AppAsset::register($this);
StarterAppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="<?= SettingSearch::defaultImage('favicon') ?>&w=16" type="image/x-icon" />

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
								<div class="d-flex align-items-baseline flex-wrap mr-5">
									<!--begin::Page Title-->
									<h4 class="text-dark font-weight-bold my-1 mr-5">Local Data</h4>
									<!--end::Page Title-->
									<!--begin::Breadcrumb-->
									<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
										<li class="breadcrumb-item">
											<a href="" class="text-dark-50">Features</a>
										</li>
										<li class="breadcrumb-item">
											<a href="" class="text-dark-50">KTDatatable</a>
										</li>
										<li class="breadcrumb-item">
											<a href="" class="text-dark-50">Base</a>
										</li>
										<li class="breadcrumb-item">
											<a href="" class="text-dark-50">Local Data</a>
										</li>
									</ul>
									<!--end::Breadcrumb-->
								</div>
								<!--end::Page Heading-->
							</div>
							<!--end::Info-->
							<!--begin::Toolbar-->
							<div class="d-flex align-items-center">
								<!--begin::Dropdown-->
								<div class="dropdown dropdown-inline" data-toggle="tooltip" title="" data-placement="top" data-original-title="Quick actions">
									<a href="#" class="btn btn-fixed-height btn-bg-white btn-text-dark-50 btn-hover-text-primary btn-icon-primary font-weight-bolder font-size-sm px-5 mr-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<span class="svg-icon svg-icon-md">
										<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Add-user.svg-->
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24"></polygon>
												<path d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
												<path d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"></path>
											</g>
										</svg>
										<!--end::Svg Icon-->
									</span>Add Member</a>
									<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right p-0 m-0">
										<!--begin::Navigation-->
										<ul class="navi navi-hover">
											<li class="navi-header pb-1">
												<span class="text-primary text-uppercase font-weight-bolder font-size-sm">Add new:</span>
											</li>
											<li class="navi-item">
												<a href="#" class="navi-link">
													<span class="navi-icon">
														<i class="flaticon2-shopping-cart-1"></i>
													</span>
													<span class="navi-text">Order</span>
												</a>
											</li>
											<li class="navi-item">
												<a href="#" class="navi-link">
													<span class="navi-icon">
														<i class="flaticon2-calendar-8"></i>
													</span>
													<span class="navi-text">Event</span>
													<span class="navi-link-badge">
														<span class="label label-light-danger label-inline font-weight-bold">new</span>
													</span>
												</a>
											</li>
											<li class="navi-item">
												<a href="#" class="navi-link">
													<span class="navi-icon">
														<i class="flaticon2-graph-1"></i>
													</span>
													<span class="navi-text">Report</span>
												</a>
											</li>
											<li class="navi-item">
												<a href="#" class="navi-link">
													<span class="navi-icon">
														<i class="flaticon2-rocket-1"></i>
													</span>
													<span class="navi-text">Post</span>
													<span class="navi-link-badge">
														<span class="label label-light-success label-rounded font-weight-bolder">5</span>
													</span>
												</a>
											</li>
											<li class="navi-item">
												<a href="#" class="navi-link">
													<span class="navi-icon">
														<i class="flaticon2-writing"></i>
													</span>
													<span class="navi-text">File</span>
												</a>
											</li>
										</ul>
										<!--end::Navigation-->
									</div>
								</div>
								<!--end::Dropdown-->
								<!--begin::Dropdown-->
								<div class="dropdown dropdown-inline" data-toggle="tooltip" title="" data-placement="top" data-original-title="Quick actions">
									<a href="#" class="btn btn-fixed-height btn-primary font-weight-bolder font-size-sm px-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<span class="svg-icon svg-icon-md">
										<!--begin::Svg Icon | path:assets/media/svg/icons/Files/File.svg-->
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24"></polygon>
												<path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
												<rect fill="#000000" x="6" y="11" width="9" height="2" rx="1"></rect>
												<rect fill="#000000" x="6" y="15" width="5" height="2" rx="1"></rect>
											</g>
										</svg>
										<!--end::Svg Icon-->
									</span>New Report</a>
									<div class="dropdown-menu dropdown-menu-md dropdown-menu-right p-0 m-0">
										<!--begin::Navigation-->
										<ul class="navi navi-hover">
											<li class="navi-header font-weight-bold py-4">
												<span class="font-size-lg">Choose Option:</span>
												<i class="flaticon2-information icon-md text-muted" data-toggle="tooltip" data-placement="right" title="" data-original-title="Click to learn more..."></i>
											</li>
											<li class="navi-separator mb-3 opacity-70"></li>
											<li class="navi-item">
												<a href="#" class="navi-link">
													<span class="navi-text">
														<span class="label label-xl label-inline label-light-primary">Orders</span>
													</span>
												</a>
											</li>
											<li class="navi-item">
												<a href="#" class="navi-link">
													<span class="navi-text">
														<span class="label label-xl label-inline label-light-danger">Reports</span>
													</span>
												</a>
											</li>
											<li class="navi-item">
												<a href="#" class="navi-link">
													<span class="navi-text">
														<span class="label label-xl label-inline label-light-warning">Tasks</span>
													</span>
												</a>
											</li>
											<li class="navi-item">
												<a href="#" class="navi-link">
													<span class="navi-text">
														<span class="label label-xl label-inline label-light-success">Events</span>
													</span>
												</a>
											</li>
											<li class="navi-item">
												<a href="#" class="navi-link">
													<span class="navi-text">
														<span class="label label-xl label-inline label-light-dark">Members</span>
													</span>
												</a>
											</li>
											<li class="navi-separator mt-3 opacity-70"></li>
											<li class="navi-footer py-4">
												<a class="btn btn-primary font-weight-bold btn-sm px-5" href="#">
												<i class="ki ki-plus icon-sm"></i>Create</a>
											</li>
										</ul>
										<!--end::Navigation-->
									</div>
								</div>
								<!--end::Dropdown-->
							</div>
							<!--end::Toolbar-->
						</div>
					</div>
					<!--begin::Entry-->
					<div class="d-flex flex-column-fluid">
						<!--begin::Container-->
						<div class="container">
							<div class="card card-custom">
								<div class="card-header flex-wrap border-0 pt-6 pb-0">
									<div class="card-title">
										<h3 class="card-label">Local Datasource
										<span class="text-muted pt-2 font-size-sm d-block">Javascript array as data source</span></h3>
									</div>
									<div class="card-toolbar">
										<!--begin::Dropdown-->
										<div class="dropdown dropdown-inline mr-2">
											<button type="button" class="btn btn-light-primary font-weight-bolder dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<span class="svg-icon svg-icon-md">
												<!--begin::Svg Icon | path:assets/media/svg/icons/Design/PenAndRuller.svg-->
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<rect x="0" y="0" width="24" height="24" />
														<path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" fill="#000000" opacity="0.3" />
														<path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" fill="#000000" />
													</g>
												</svg>
												<!--end::Svg Icon-->
											</span>Export</button>
											<!--begin::Dropdown Menu-->
											<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
												<!--begin::Navigation-->
												<ul class="navi flex-column navi-hover py-2">
													<li class="navi-header font-weight-bolder text-uppercase font-size-sm text-primary pb-2">Choose an option:</li>
													<li class="navi-item">
														<a href="#" class="navi-link">
															<span class="navi-icon">
																<i class="la la-print"></i>
															</span>
															<span class="navi-text">Print</span>
														</a>
													</li>
													<li class="navi-item">
														<a href="#" class="navi-link">
															<span class="navi-icon">
																<i class="la la-copy"></i>
															</span>
															<span class="navi-text">Copy</span>
														</a>
													</li>
													<li class="navi-item">
														<a href="#" class="navi-link">
															<span class="navi-icon">
																<i class="la la-file-excel-o"></i>
															</span>
															<span class="navi-text">Excel</span>
														</a>
													</li>
													<li class="navi-item">
														<a href="#" class="navi-link">
															<span class="navi-icon">
																<i class="la la-file-text-o"></i>
															</span>
															<span class="navi-text">CSV</span>
														</a>
													</li>
													<li class="navi-item">
														<a href="#" class="navi-link">
															<span class="navi-icon">
																<i class="la la-file-pdf-o"></i>
															</span>
															<span class="navi-text">PDF</span>
														</a>
													</li>
												</ul>
												<!--end::Navigation-->
											</div>
											<!--end::Dropdown Menu-->
										</div>
										<!--end::Dropdown-->
										<!--begin::Button-->
										<a href="#" class="btn btn-primary font-weight-bolder">
										<span class="svg-icon svg-icon-md">
											<!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24" />
													<circle fill="#000000" cx="9" cy="15" r="6" />
													<path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
												</g>
											</svg>
											<!--end::Svg Icon-->
										</span>New Record</a>
										<!--end::Button-->
									</div>
								</div>
								<div class="card-body">
									<?= $content ?>
								</div>
							</div>
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
	<?= $this->render('_chat_panel') ?>
	<!--end::Chat Panel-->

	<!--begin::Scrolltop-->
	<?= $this->render('_scroll_top') ?>
	<!--end::Scrolltop-->

	<!--begin::Sticky Toolbar-->
	<?= $this->render('_sticky_toolbar') ?>
	<!--end::Sticky Toolbar-->

	<!--begin::Demo Panel-->
	<?= $this->render('_demo_panel') ?>
	<!--end::Demo Panel-->

	<script>var HOST_URL = "https://preview.keenthemes.com/keen/theme/tools/preview";</script>
	<!--begin::Global Config(global config for global JS scripts)-->
	<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#8950FC", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
	<!--end::Global Config-->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
