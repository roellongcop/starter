<?php

use app\helpers\Html;
?>
<div class="topbar">
    <?= Html::if(($searchModel = $this->params['searchModel'] ?? '') != NULL, 
        function() use($searchModel) {
            return $this->render('_topbar-search-form', [
                'searchModel' => $searchModel,
                'searchAction' => $searchModel->searchAction ?? ['index'],
            ]);
        }
    ) ?>
    
    <!--begin::Search-->
    <?php # $this->render('toolbar/_search') ?>
    <!--end::Search-->
    <!--begin::Quick panel-->
    <?= $this->render('toolbar/_quick_panel') ?>
    <!--end::Quick panel-->
    <!--begin::Quick Actions-->
    <?= $this->render('toolbar/_quick_actions') ?>
    <!--end::Quick Actions-->
    <!--begin::Chat-->
    <?php # $this->render('toolbar/_chat') ?>
    <!--end::Chat-->
    <!--begin::User-->
    <?= $this->render('toolbar/_user') ?>
    <!--end::User-->
    <!--begin::Dropdown-->
    <?php # $this->render('toolbar/_dropdown') ?>
    <!--end::Dropdown-->
</div>