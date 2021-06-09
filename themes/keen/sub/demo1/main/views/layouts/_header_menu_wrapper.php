<?php
use app\widgets\AnchorBack;
use app\widgets\Search;
use yii\widgets\ActiveForm;

$searchModel = $this->params['searchModel'] ?? '';
$searchAction = $searchModel->searchAction ?? ['index'];
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
        <?php if ($searchModel): ?>
            <?php $form = ActiveForm::begin([
                'id' => 'main-search-form',
                'action' => $searchAction, 
                'method' => 'get'
            ]); ?>
                <?= Search::widget([
                    'model' => $searchModel,
                    'style' => 'margin-top: 17px;width: 30vw;margin-left: 10px;'
                ]) ?>
            <?php ActiveForm::end(); ?>
        <?php endif ?>
        <!--end::Header Nav-->
    </div>
    <!--end::Header Menu-->
</div>