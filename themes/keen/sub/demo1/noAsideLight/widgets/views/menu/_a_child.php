<?php

use app\helpers\Html;
?>

<a href="<?= $menu['link'] ?? '' ?>" class="menu-link" 
	target="<?= isset($menu['new_tab'])? '_blank': '_self' ?>">
	<?= Html::if($withIcon, 
		'<span class="svg-icon menu-icon">
	    	'.  ($menu['icon'] ?? '') .'
		</span>'
	) ?>
    <span class="menu-text">
        <?= ($menu['label'] ?? '') ?>
    </span>
</a>