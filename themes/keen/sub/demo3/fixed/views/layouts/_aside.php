<?php

use app\helpers\App;
use app\helpers\Html;
?>
<div class="aside aside-left d-flex flex-column" id="kt_aside">
	<!--begin::Brand-->
	<div class="aside-brand d-none d-lg-flex flex-column align-items-center flex-column-auto pt-10 pb-5">
		<!--begin::Logo-->
		<a href="index.html">
			<?= Html::image(App::setting('image')->primary_logo, ['w' => 50, 'quality' => 90], [
	            'alt' => 'Primary Logo',
	        ]) ?>
		</a>
		<!--end::Logo-->
	</div>
	<!--end::Brand-->
	<!--begin::Nav Wrapper-->
	<div class="aside-nav d-flex flex-column justify-content-lg-center align-items-center flex-column-fluid py-5 pt-lg-0 pb-lg-20">
		<!--begin::Nav-->
		<ul class="nav flex-column">
			<!--begin::Item-->
			<li class="nav-item mb-2" data-toggle="tooltip" data-placement="right" data-container="body" data-boundary="window" title="Latest Projects">
				<a href="#" class="nav-link btn btn-icon btn-icon-white btn-hover-primary btn-lg active">
					<i class="flaticon2-protection"></i>
				</a>
			</li>
			<!--end::Item-->
			<!--begin::Item-->
			<li class="nav-item mb-2" data-toggle="tooltip" data-placement="right" data-container="body" data-boundary="window" title="New Features">
				<a href="#" class="nav-link btn btn-icon btn-icon-white btn-hover-icon-primary btn-lg">
					<i class="flaticon2-hourglass-1"></i>
				</a>
			</li>
			<!--end::Item-->
			<!--begin::Item-->
			<li class="nav-item mb-2" data-toggle="tooltip" data-placement="right" data-container="body" data-boundary="window" title="Latest Reports">
				<a href="#" class="nav-link btn btn-icon btn-icon-white btn-hover-icon-primary btn-lg">
					<i class="flaticon2-protected"></i>
				</a>
			</li>
			<!--end::Item-->
			<!--begin::Item-->
			<li class="nav-item mb-2" data-toggle="tooltip" data-placement="right" data-container="body" data-boundary="window" title="Project Management">
				<a href="#" class="nav-link btn btn-icon btn-icon-white btn-hover-icon-primary btn-lg">
					<i class="flaticon2-shopping-cart-1"></i>
				</a>
			</li>
			<!--end::Item-->
			<!--begin::Item-->
			<li class="nav-item mb-2" data-toggle="tooltip" data-placement="right" data-container="body" data-boundary="window" title="User Management">
				<a href="#" class="nav-link btn btn-icon btn-icon-white btn-hover-icon-primary btn-lg">
					<i class="flaticon2-writing"></i>
				</a>
			</li>
			<!--end::Item-->
			<!--begin::Item-->
			<li class="nav-item mb-2" data-toggle="tooltip" data-placement="right" data-container="body" data-boundary="window" title="Finance &amp; Accounting">
				<a href="#" class="nav-link btn btn-icon btn-icon-white btn-hover-icon-primary btn-lg">
					<i class="flaticon2-drop"></i>
				</a>
			</li>
			<!--end::Item-->
		</ul>
		<!--end::Nav-->
	</div>
	<!--end::Nav Wrapper-->
</div>