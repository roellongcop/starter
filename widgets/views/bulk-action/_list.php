<?php

use app\helpers\Html;
use app\widgets\AppIcon;
?>
<li class="navi-item">
    <a href="#" class="navi-link bulk-action" data-process="<?= $bulkAction['process'] ?>">
        <?= Html::ifElse(
            Html::isHtml($bulkAction['icon']),
            $bulkAction['icon'],
            function() use($bulkAction) {
                return AppIcon::widget(['icon' => $bulkAction['icon']]);
            }
        ) ?>
        &nbsp;
        <span class="navi-text">
            <?= $bulkAction['label'] ?>
        </span>
    </a>
</li>