<?php

use app\helpers\App;
use app\helpers\Html;

$identity = App::identity();
$access = App::component('access');
?>
<div class="sidebar sidebar-right d-flex flex-row-auto flex-column bg-white" id="kt_sidebar">
	<!--begin::Sidebar Header-->
	<div class="sidebar-header flex-column-auto pt-5 pb-5 px-5 pt-lg-14 px-lg-10">
		<!--begin::Toolbar-->
		<div class="d-flex justify-content-between">
			<!--begin::User-->
			<div class="dropdown dropdown-inline">
				<a href="#" class="d-flex align-items-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<div class="symbol symbol-40 mr-4 bg-gray-100">
						<?= Html::image($identity->photo, ['w' => 50, 'quality' => 90], [
				            'alt' => 'Profile Image',
				            'class' => 'h-75 align-self-end',
				            'id' => 'profile-image-desktop'
				        ]) ?>
						<!-- <div class="symbol-label">
							
						</div>
						<i class="symbol-badge bg-success"></i> -->
					</div>
					<div class="d-flex flex-column">
						<span class="text-dark-75 font-weight-bolder">
							<?= $identity->roleName ?>
						</span>
						<span class="text-muted font-weight-bold">
							<?= $identity->username ?>
						</span>
					</div>
				</a>
				<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg p-0">
					<!--begin::Header-->
					<div class="d-flex align-items-center justify-content-between p-8 rounded-top">
						<!--begin::User-->
						<div class="d-flex align-items-center">
							<!--begin::Symbol-->
							<div class="symbol symbol-md bg-light-primary mr-3 flex-shrink-0">
								<?= Html::image($identity->photo, ['w' => 50, 'quality' => 90], [
									'alt' => 'Profile Photo',
									'id' => 'profile-image-dropdown'
								]) ?>
							</div>
							<!--end::Symbol-->
							<!--begin::Text-->
							<div class="d-flex flex-column mr-2">
								<span class="text-dark-75 font-weight-bolder">
									<?= $identity->roleName ?>
								</span>
								<span class="text-muted font-weight-bold">
									<?= $identity->username ?>
								</span>
							</div>
						</div>
						<!--end::User-->
						<!--begin::Text-->
						<!-- <span class="label label-light-success label-lg font-weight-bold label-inline">3 messages</span> -->
						<!--end::Text-->
					</div>
					<div class="separator separator-solid"></div>
					<!--end::Header-->
					<!--begin::Nav-->
					<div class="navi navi-spacer-x-0 pt-5">
						<?= Html::a(<<< HTML
								<div class="navi-link">
									<div class="navi-icon mr-2">
										<i class="flaticon2-calendar-3 text-success"></i>
									</div>
									<div class="navi-text">
										<div class="font-weight-bold">My Profile</div>
										<div class="text-muted">Account settings and more
										<span class="label label-light-danger label-inline font-weight-bold">update</span></div>
									</div>
								</div>
							HTML, ['user/my-account'], ['class' => 'navi-item px-8']
						) ?>

						<?= Html::a(<<< HTML
								<div class="navi-link">
									<div class="navi-icon mr-2">
										<i class="fa fa-lock text-info"></i>
									</div>
									<div class="navi-text">
										<div class="font-weight-bold">My Password</div>
										<div class="text-muted">Change Password</div>
									</div>
								</div>
							HTML, ['user/my-password'], ['class' => 'navi-item px-8']
						) ?>

						<?= Html::a(<<< HTML
								<div class="navi-link">
									<div class="navi-icon mr-2">
										<i class="fa fa-file text-warning"></i>
									</div>
									<div class="navi-text">
										<div class="font-weight-bold">My Files</div>
										<div class="text-muted">File Manager</div>
									</div>
								</div>
							HTML, ['file/my-files'], ['class' => 'navi-item px-8']
						) ?>

						<?= Html::a(<<< HTML
								<div class="navi-link">
									<div class="navi-icon mr-2">
										<i class="flaticon2-rocket-1 text-danger"></i>
									</div>
									<div class="navi-text">
										<div class="font-weight-bold">My Settings</div>
										<div class="text-muted">General & Themes</div>
									</div>
								</div>
							HTML, ['setting/my-setting'], ['class' => 'navi-item px-8']
						) ?>

						<?= Html::a(<<< HTML
								<div class="navi-link">
									<div class="navi-icon mr-2">
										<i class="flaticon2-hourglass text-primary"></i>
									</div>
									<div class="navi-text">
										<div class="font-weight-bold">My Role</div>
										<div class="text-muted">Access and Navigations</div>
									</div>
								</div>
							HTML, ['role/my-role'], ['class' => 'navi-item px-8']
						) ?>
 
						<!--begin::Footer-->
						<div class="navi-separator mt-3"></div>
						<div class="navi-footer px-8 py-5">
							<?= Html::beginForm(['site/logout'], 'post') ?>
		                        <?= Html::submitButton(
		                            'Sign Out',
		                            ['class' => 'btn btn-light-primary font-weight-bold']
		                        ) ?>
		                    <?= Html::endForm() ?>
						</div>
						<!--end::Footer-->
					</div>
					<!--end::Nav-->
				</div>
			</div>
			<!--end::User-->
			<!--begin::Dropdown-->
			<?php # $this->render('_sidebar_user_toolbar') ?>
			<!--end::Dropdown-->
		</div>
		<!--end::Toolbar-->
	</div>
	<!--end::Sidebar Header-->
	<!--begin::Sidebar Content-->
	<div class="sidebar-content flex-column-fluid pb-10 pt-7 px-5 px-lg-10">
		<div class="sidebar-wrapper scroll-pull">
	        <div class="mb-15" style="width: 100%">
	            <h5 class="font-weight-bold mb-5">Advanced Filter</h5>
	            <!--begin::Timeline-->
	            <?= Html::advancedFilter($this->params['searchModel'] ?? '') ?>
	            <!--end::Timeline-->
	        </div>
	        
		</div>
	</div>
	<!--end::Sidebar Content-->
</div>