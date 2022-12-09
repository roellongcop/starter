<?php
use app\widgets\Menu;
?>
<div id="kt_header" class="header header-fixed">
	<!--begin::Container-->
	<div class="container">
		<!--begin::Header Menu Wrapper-->
		<div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
			<!--begin::Header Menu-->
			<div id="kt_header_menu" class="header-menu header-menu-left header-menu-mobile header-menu-layout-default">
				<!--begin::Header Nav-->
				<?= Menu::widget([
            		'viewParams' => $this->params
				]) ?>
				<!--end::Header Nav-->
			</div>
			<!--end::Header Menu-->
		</div>
		<!--end::Header Menu Wrapper-->
		<!--begin::Topbar-->
		<?= $this->render('_topbar') ?>
		<!--end::Topbar-->
	</div>
	<!--end::Container-->
</div>