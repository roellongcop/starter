<?php

use app\helpers\App;
use app\helpers\Html;
?>

<?= Html::foreach($menus, function($menu, $key) use ($subMenuClass, $withIcon) {
    return Html::ifElse(isset($menu['group_menu']) && $menu['group_menu'], 
        '', 
        function() use($menu, $withIcon, $subMenuClass) {
            return $this->render('_link_creator-content', [
                'menu' => $menu,
                'withIcon' => $withIcon,
                'subMenuClass' => $subMenuClass,
            ]);
        }
    );
}) ?>