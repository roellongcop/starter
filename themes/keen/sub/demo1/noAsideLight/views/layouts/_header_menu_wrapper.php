<?php

use app\helpers\App;
use app\widgets\AnchorBack;
use app\widgets\Menu;
use app\widgets\Search;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$searchModel = $this->params['searchModel'] ?? '';
$searchAction = $searchModel->searchAction ?? ['index'];

?>
<div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
    <!--begin::Header Logo-->
    <div class="header-logo">
        <a href="index.html">
            <?= Html::img(App::setting('primary_logo') . '&w=90&quality=90', [
                'class' => 'h-30px',
                'alt' => App::appName()
            ]) ?>
        </a>
    </div>
    <!--end::Header Logo-->
    <!--begin::Header Menu-->
    <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
        
        <!--begin::Header Nav-->
        <?= Menu::widget() ?>
        <!--end::Header Nav-->

        
        <?php if ($searchModel): ?>
            <?php $form = ActiveForm::begin(['action' => $searchAction, 'method' => 'get']); ?>
                <?= Search::widget([
                    'model' => $searchModel,
                    'style' => 'margin-top: 17px;width: 30vw;margin-left: 10px;'
                ]) ?>
            <?php ActiveForm::end(); ?>
        <?php endif ?>
    </div>
    <!--end::Header Menu-->
</div>