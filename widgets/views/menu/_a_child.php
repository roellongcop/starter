<a href="<?= \app\helpers\App::baseUrl() . $menu['link'] ?? '' ?>" class="menu-link" 
	target="<?= isset($menu['new_tab'])? '_blank': '_self' ?>">
	<span class="svg-icon menu-icon">
    	<?= $menu['icon'] ?? '' ?>
	</span>
    <span class="menu-text">
        <?= $menu['label'] ?? '' ?>
    </span>
</a>