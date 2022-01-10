<?php

use app\helpers\Html;
use app\widgets\AnchorBack;
?>
<div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
    <!--begin::Header Menu-->
    <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
        <!--begin::Header Nav-->
        <div style="margin-top: 17px;">
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
        
        <?= Html::if(($searchModel = $this->params['searchModel'] ?? '') != NULL, 
            function() use($searchModel) {
                return $this->render('_header_menu_wrapper-content', [
                    'searchModel' => $searchModel,
                    'searchAction' => $searchModel->searchAction ?? ['index'],
                ]);
            }
        ) ?>
        <!--end::Header Nav-->
    </div>
    <!--end::Header Menu-->
</div>