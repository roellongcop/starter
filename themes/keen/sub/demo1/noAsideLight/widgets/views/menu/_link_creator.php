<?php

use app\helpers\App;
use app\helpers\Html;

?>

<?= Html::foreach($menus, function($key, $menu) use ($subMenuClass) {
    return Html::ifELse(isset($menu['group_menu']) && $menu['group_menu'], '', $this->render('_link_creator-content', [
        'menu' => $menu,
        'withIcon' => $withIcon,
        'subMenuClass' => $subMenuClass,
    ]));
}) ?>