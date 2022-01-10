<?php

use app\helpers\Html;
?>
<?= Html::if($menus, function() use($menus) {
    return Html::tag('ul', 
        $this->render('_link_creator', [
            'menus' => $menus,
            'withIcon' => false,
            'subMenuClass' => ''
        ]), 
        ['class' => 'menu-nav']
    );
}) ?>

