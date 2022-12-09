<?php

use app\widgets\Menu;
?>
<div class="aside-offcanvas aside-offcanvas-left d-flex flex-column flex-row-auto" id="kt_aside_offcanvas">
	<!--begin::Aside Offcanvas Menu-->
	<div class="aside-offcanvas-menu-wrapper flex-column-fluid" id="kt_aside_offcanvas_menu_wrapper">
		<!--begin::Menu Container-->
		<div id="kt_aside_offcanvas_menu" class="aside-offcanvas-menu my-4" data-menu-vertical="1">
			<!--begin::Menu Nav-->
			<?= Menu::widget([
            	'viewParams' => $this->params
			]) ?>
			<!--end::Menu Nav-->
		</div>
		<!--end::Menu Container-->
	</div>
	<!--end::Aside Offcanvas  Menu-->
</div>