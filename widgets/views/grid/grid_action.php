<?php

use app\helpers\Html;
?>
<div class="dropdown dropdown-inline" data-toggle="tooltip" title="" data-placement="left">
    <a href="#" class="btn btn-fixed-height btn-bg-white btn-text-dark-50 btn-hover-text-primary btn-icon-primary font-weight-bolder font-size-sm  mr-3 btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border: 1px solid #ccc;">
    <span class="svg-icon svg-icon-md">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z" fill="#000000"/>
    </g>
</svg><!--end::Svg Icon-->
    </span>
	Manage
	</a>
    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right p-0 m-0">
        <!--begin::Navigation-->
        <ul class="navi navi-hover">
            <?= Html::foreach($template, function($t) {
                return Html::if($t, Html::tag('li', $t, ['class' => 'navi-item']));
            }) ?>
        </ul>
        <!--end::Navigation-->
    </div>
</div>