<?php

use app\helpers\App;
?>
<div class="topbar">


    <!--begin::Search-->
    <?php # $this->render('_search_layout') ?>
    <!--end::Search-->


    <!--begin::Quick panel-->
    <?= $this->render('_quick_panel') ?>
    <!--end::Quick panel-->

    <!--begin::Notifications-->
    <?= $this->render('_notifications') ?>
    <!--end::Notifications-->


    <!--begin::Quick Actions-->
    <?= $this->render('_quick_actions') ?>
    <!--end::Quick Actions-->


    


    <!--begin::Chat-->
    <?php #$this->render('_chat') ?>
    <!--end::Chat-->


    <!--begin::Languages-->
    <?php # $this->render('_languages') ?>
    <!--end::Languages-->


    <!--begin::User-->
    <?= $this->render('_user') ?>
    <!--end::User-->

</div>