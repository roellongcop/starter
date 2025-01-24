<?php

use app\helpers\Html;

$this->registerCss(<<< CSS
    .app-alert {
        background: #fff;
        padding: 15px;
        box-shadow: rgb(0 0 0 / 20%) 0px 1px 4px 0;
        display: inline-flex;
        width: 100%;
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
        margin-bottom: 1rem;
        border-radius: 4px;
    }
    .app-alert .content-alert {margin-bottom: 0; margin-top: 0.7rem;}
    .app-alert .head-alert {font-size: 1.2rem; font-weight: 500;}
    .app-alert .close-alert {margin: auto 0; cursor: pointer; margin-top: 0}
    .primary-alert {border-left: 4px solid #4085f0;}
    .success-alert {border-left: 4px solid #1BC5BD;}
    .warning-alert {border-left: 4px solid #ffbc46;}
    .info-alert {border-left: 4px solid #00b5e5;}
    .danger-alert {border-left: 4px solid #ff3a46;}
    .primary-alert .head-alert i {color: #4085f0;}
    .success-alert .head-alert i {color: #1BC5BD;}
    .warning-alert .head-alert i {color: #ffbc46;}
    .info-alert .head-alert i {color: #00b5e5;}
    .danger-alert .head-alert i {color: #ff3a46;}

CSS);

$this->registerJs(<<< JS
    $('.close-alert').click(function() {
        $(this).closest('.app-alert').remove();
    });
JS);
?>

<div class="app-alert <?= $type ?>-alert" id="<?= $widgetId ?>">
    <div>
        <div class="head-alert">
            <?= $icon ?>
            <?= $head ?>
        </div>
        <p class="content-alert">
            <?= $message ?>
        </p>
    </div>
    <?= Html::if($withClose, '<div class="close-alert"> <i class="ki ki-close"></i> </div>') ?>
</div>
