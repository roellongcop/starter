<?php
use app\helpers\App;

$searchModel = $this->params['searchModel'] ?? '';
$searchTemplate = $searchModel->searchTemplate ?? App::controllerID() . '/_search';
?>
<?php if ($searchModel): ?>
    <div id="kt_quick_panel" class="offcanvas offcanvas-right pt-5 pb-10">
        <!--begin::Content-->
        <div class="offcanvas-content px-5 offcanvas-header offcanvas-header-navs d-flex align-items-center justify-content-between mb-5">
            <div class="mb-15" style="width: 100%">
                <h5 class="font-weight-bold mb-5">Advanced Filter</h5>
                <!--begin::Timeline-->
                <?php if ($searchModel): ?>
                    <?= $this->render("/{$searchTemplate}", [
                        'model' => $searchModel
                    ]) ?>
                <?php endif ?>
                <!--end::Timeline-->
            </div>
            <div class="offcanvas-close mt-n1 pr-5">
                <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_panel_close">
                    <i class="ki ki-close icon-xs text-muted"></i>
                </a>
            </div>
        </div>
        <!--end::Content-->
    </div>
<?php endif ?>
