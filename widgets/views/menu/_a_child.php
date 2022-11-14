<?php

use app\helpers\App;

$url = filter_var($menu['link'] ?? '', FILTER_VALIDATE_URL)? $menu['link']: App::baseUrl($menu['link']);
?>

<a href="<?= $url ?>" class="menu-link" 
	target="<?= isset($menu['new_tab'])? '_blank': '_self' ?>">
	<span class="svg-icon menu-icon">
    	<?= $menu['icon'] ?? '' ?>
	</span>
    <span class="menu-text">
        <?= $menu['label'] ?? '' ?>
    </span>
</a>