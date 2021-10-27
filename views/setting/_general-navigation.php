<?php

use app\helpers\Url;
?>
<li class="navi-item">
    <a class="navi-link <?= ($keyTab == $tab)? 'active': '' ?>" href="<?= Url::to(['setting/general', 'tab' => $keyTab]) ?>">
        <span class="navi-icon">
        	<?= $menu['icon'] ?>
        </span>
        <span class="navi-text">
        	<?= $menu['label'] ?>
        </span>
    </a>
</li>