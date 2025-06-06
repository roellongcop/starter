<?php

use app\helpers\App;
use app\helpers\Html;
use app\widgets\AnchorBack;
?>

<div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed">
    <!--begin::Logo-->
    <a href="/">
        <?= Html::image(App::setting('image')->primary_logo, ['w' => 50, 'quality' => 90], [
            'alt' => 'Primary Logo',
        ]) ?>
    </a>
    <!--end::Logo-->
    <div style="position: absolute; left: 72px;">
        <?= AnchorBack::widget([
            'title' => '<i class="fa fa-angle-left"></i>',
            'options' => [
                'class' => 'btn btn-secondary btn-sm',
                'data-original-title' => 'Go back',
                'data-toggle' => "tooltip",
                'data-theme' => "dark",
            ]
        ]) ?>
    </div>
    <!--begin::Toolbar-->
    <div style="position: absolute; width: 50%; left: 111px;">
        <?= Html::if($this->params['searchModel'] ?? false, 
            function($searchModel) {
                return $this->render('_header_mobile-content', [
                    'searchModel' => $searchModel,
                    'searchAction' => $searchModel->searchAction ?? ['index'],
                ]);
            }
        ) ?>
    </div>
    <div class="d-flex align-items-center">
        <!--begin::Header Menu Mobile Toggle-->
       <!--  <button class="btn p-0 burger-icon ml-5" id="kt_header_mobile_toggle">
            <span></span>
        </button> -->
        <!--end::Header Menu Mobile Toggle-->
        <!--begin::Aside Mobile Toggle-->
        <button class="btn p-0 burger-icon burger-icon-left" id="kt_aside_mobile_toggle">
            <span></span>
        </button>
        <!--end::Aside Mobile Toggle-->
        <!--begin::Topbar Mobile Toggle-->
        <button class="btn btn-hover-text-primary p-0 ml-3" id="kt_header_mobile_topbar_toggle">
            <span class="svg-icon svg-icon-xl">
                <!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24" />
                        <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                        <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                    </g>
                </svg>
                <!--end::Svg Icon-->
            </span>
        </button>
        <!--end::Topbar Mobile Toggle-->
    </div>
    <!--end::Toolbar-->
</div>