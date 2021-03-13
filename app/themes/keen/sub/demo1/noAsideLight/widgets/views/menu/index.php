<?php if ($menus): ?>
    <ul class="menu-nav">
        <?= $this->render('_link_creator', [
        	'menus' => $menus,
        	'withIcon' => false,
        	'subMenuClass' => ''
        ]) ?>
    </ul>
<?php endif ?>