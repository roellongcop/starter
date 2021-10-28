<?php

use app\helpers\App;
use app\helpers\Html;

$controller = $this->params['controller'] ?? App::controllerID();
?>

<?= Html::foreach($menus, function($key, $menu) use ($controller) {
    return Html::ifElse(
        isset($menu['group_menu']) && $menu['group_menu'],
        '<li class="menu-section">
            <h4 class="menu-text">'. $menu['label'] .'</h4>
            <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
        </li>',
        Html::ifElse(
            !empty($menu['sub']),
            '<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                '. $this->render('_a_parent', ['menu' => $menu]) .'
                
                <div class="menu-submenu">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                        '. $this->render('_link_creator', ['menus' => $menu['sub']]) .'
                    </ul>
                </div>
            </li>',
            '<li class="menu-item '. ((Html::navController($menu['link']) == $controller) ? 'menu-item-active': '') .'" aria-haspopup="true">
                '. $this->render('_a_child', ['menu' => $menu]) .'
            </li>'
        )
    );
}) ?>