<?php

use app\helpers\App;
use app\widgets\Menu as MenuCreator;

?>

<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
    <!--begin::Menu Container-->
    <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
        <!--begin::Menu Nav-->
        <?= MenuCreator::widget() ?>
        <!--end::Menu Nav-->
    </div>
    <!--end::Menu Container-->
</div>