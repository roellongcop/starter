<?php

use app\helpers\App;
use app\helpers\Html;

$controller = $this->params['controller'] ?? App::controllerID();
?>

<?= Html::ifELse(!empty($menu['sub']),
    function() use($menu, $subMenuClass) {
        $parent = $this->render('_a_parent', ['menu' => $menu]);
        $sub = $this->render('_link_creator', [
            'menus' => $menu['sub'] ?? [],
            'withIcon' => true,
            'subMenuClass' => 'menu-submenu-right'
        ]);
        return <<< HTML
            <li class="menu-item menu-item-submenu " aria-haspopup="true" data-menu-toggle="hover" aria-haspopup="true">
                {$parent}
                <div class="menu-submenu menu-submenu-classic {$subMenuClass}">
                    <ul class="menu-subnav"> {$sub} </ul>
                </div>
            </li> 
        HTML;
    },
    function() use($menu, $controller, $withIcon) {
        $class = (Html::navController($menu['link']) == $controller) ? 'menu-item-active': '';
        $child = $this->render('_a_child', [
            'menu' => $menu,
            'withIcon' => $withIcon,
        ]);

        return <<< HTML
            <li class="menu-item {$class}" aria-haspopup="true"> {$child} </li>
        HTML;
    }
) ?>
 