<?php

use app\helpers\App;
use app\helpers\Html;
?>
<div class="subheader bg-white h-100px" id="kt_subheader">
	<div class="container-fluid flex-wrap flex-sm-nowrap">
		<!--begin::Logo-->
		<div class="d-none d-lg-flex align-items-center flex-wrap w-250px">
			<!--begin::Logo-->
			<a href="index.html">
				<?= Html::image(App::setting('image')->primary_logo, ['w' => 150, 'quality' => 90], [
		            'alt' => 'Primary Logo',
		            'class' => 'max-h-50px',
		        ]) ?>
			</a>
			<!--end::Logo-->
		</div>
		<!--end::Logo-->
		<!--begin::Nav-->
		<div class="subheader-nav nav flex-grow-1">
			<!--begin::Item-->
			<a href="#" class="nav-item">
				<span class="nav-label px-10">
					<span class="nav-title text-dark-75 font-weight-bold font-size-h4">My Account</span>
					<span class="nav-desc text-muted">Profile &amp; Account</span>
				</span>
			</a>
			<!--end::Item-->
			<!--begin::Item-->
			<a href="#" class="nav-item active">
				<span class="nav-label px-10">
					<span class="nav-title text-dark-75 font-weight-bold font-size-h4">Orders</span>
					<span class="nav-desc text-muted">My Order List</span>
				</span>
			</a>
			<!--end::Item-->
			<!--begin::Item-->
			<a href="#" class="nav-item">
				<span class="nav-label px-10">
					<span class="nav-title text-dark-75 font-weight-bold font-size-h4">Deposits</span>
					<span class="nav-desc text-muted">Account &amp; Reports</span>
				</span>
			</a>
			<!--end::Item-->
			<!--begin::Item-->
			<a href="#" class="nav-item">
				<span class="nav-label px-10">
					<span class="nav-title text-dark-75 font-weight-bold font-size-h4">Transfers</span>
					<span class="nav-desc text-muted">Transactions History</span>
				</span>
			</a>
			<!--end::Item-->
			<!--begin::Item-->
			<a href="#" class="nav-item">
				<span class="nav-label px-10">
					<span class="nav-title text-dark-75 font-weight-bold font-size-h4">Statements</span>
					<span class="nav-desc text-muted">Dashboard &amp; Reports</span>
				</span>
			</a>
			<!--end::Item-->
		</div>
		<!--end::Nav-->
	</div>
</div>