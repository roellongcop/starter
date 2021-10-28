<?php

use app\helpers\Html;

$searchModel = $this->params['searchModel'] ?? '';
$searchAction = $searchModel->searchAction ?? ['index'];
?>
<div class="topbar">
    <?= Html::if($searchModel, $this->render('_topbar-search-form', [
        'searchAction' => $searchAction,
        'searchModel' => $searchModel,
    ])) ?>
    
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