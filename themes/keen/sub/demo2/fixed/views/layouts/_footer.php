<?php

use app\helpers\App;
?>
<div class="footer py-2 py-lg-0 my-5 my-lg-0 d-flex flex-lg-column" id="kt_footer">
	<!--begin::Container-->
	<div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
		<!--begin::Copyright-->
		<div class="text-dark order-2 order-md-1">
			<span class="text-muted font-weight-bold mr-2"><?= date('Y') ?>©</span>
			<a href="http://keenthemes.com/keen" target="_blank" class="text-dark-75 text-hover-primary">
				<?= App::appName() ?>
			</a>
		</div>
		<!--end::Copyright-->
		<!--begin::Nav-->
		<div class="nav nav-dark order-1 order-md-2">
			<a href="http://keenthemes.com/keen" target="_blank" class="nav-link pr-3 pl-0">About</a>
			<a href="http://keenthemes.com/keen" target="_blank" class="nav-link px-3">Team</a>
			<a href="http://keenthemes.com/keen" target="_blank" class="nav-link pl-3 pr-0">Contact</a>
		</div>
		<!--end::Nav-->
	</div>
	<!--end::Container-->
</div>