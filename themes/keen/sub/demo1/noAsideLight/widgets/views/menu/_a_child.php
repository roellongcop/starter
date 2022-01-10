<?php

use app\helpers\Html;
?>

<a href="<?= $menu['link'] ?? '' ?>" class="menu-link" 
	target="<?= isset($menu['new_tab'])? '_blank': '_self' ?>">
	<?= Html::if($withIcon, 
		Html::tag('span', $menu['icon'] ?? '', ['class' => 'svg-icon menu-icon'])
	) ?>
    <span class="menu-text">
        <?= ($menu['label'] ?? '') ?>
    </span>
</a>