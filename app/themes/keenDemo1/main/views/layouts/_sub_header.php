<?php

use app\widgets\Anchors;
use app\widgets\Breadcrumbs;
use app\widgets\ExportButton;
$createController = $this->params['createController'] ?? '';

?>
<div class="subheader py-6 py-lg-8 subheader-transparent" id="kt_subheader">
    <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
    <!-- <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"> -->
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">
            <!--begin::Page Heading-->
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <!--begin::Page Title-->
                <h5 class="text-dark font-weight-bold my-1 mr-5">
                    <?= $this->title ?>
                </h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <?= Breadcrumbs::widget([
                    'homeLink' => [
                        'label' => 'Dashboard',
                        'url' => ['dashboard/index']
                    ],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    'options' => [
                        'class' => 'breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm',
                    ],
                    'itemTemplate' => "<li class='breadcrumb-item'>{link}</li>\n",
                    'activeItemTemplate' => "<li class=\"breadcrumb-item\">{link}</li>\n",
                    'anchorClass' => 'text-muted'
                ]); ?>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page Heading-->
        </div>
        <!--end::Info-->
        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
           
            <!--begin::Dropdown-->
            <?php if ($this->params['showExportButton'] ?? ''): ?>
                <?= ExportButton::widget() ?>
            <?php endif ?>
            <!--end::Dropdown-->

            <?php if ($this->params['showCreateButton'] ?? ''): ?>
                <?= Anchors::widget([
                    'names' => 'create',
                    'controller' => $createController,
                ]); ?>
            <?php endif ?>
            
        </div>
        <!--end::Toolbar-->
    </div>
</div>

