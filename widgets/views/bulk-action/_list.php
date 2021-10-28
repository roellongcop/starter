<?php

use app\helpers\Html;
?>
<li class="navi-item">
    <a href="#" class="navi-link bulk-action" data-process="<?= $bulkAction['process'] ?>">
        <?= Html::ifElse(
            Html::isHtml($bulkAction['icon']),
            $bulkAction['icon'],
            $this->render('icon/'. $bulkAction['icon'])
        ) ?>
        &nbsp;
        <span class="navi-text">
            <?= $bulkAction['label'] ?>
        </span>
    </a>
</li>