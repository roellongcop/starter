<a href="<?= $menu['link'] ?? '' ?>" class="menu-link" 
	target="<?= isset($menu['new_tab'])? '_blank': '_self' ?>">
	<?php if ($withIcon): ?>
		<span class="svg-icon menu-icon">
	    	<?= $menu['icon'] ?? '' ?>
		</span>
	<?php endif ?>
    <span class="menu-text">
        <?= $menu['label'] ?? '' ?>
    </span>
</a>