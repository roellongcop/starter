<?php

use app\helpers\Html;
?>

<?= Html::if($menus, '
    <ul class="menu-nav">
        '. $this->render('_link_creator', [
            'menus' => $menus,
            'withIcon' => false,
            'subMenuClass' => ''
        ]) .'
    </ul>
') ?>