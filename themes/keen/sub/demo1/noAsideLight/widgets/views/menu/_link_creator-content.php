<?php

use app\helpers\App;
use app\helpers\Html;

$controller = $this->params['controller'] ?? App::controllerID();
?>

<?= Html::ifELse(!empty($menu['sub']),
    '
        <li class="menu-item menu-item-submenu " aria-haspopup="true" data-menu-toggle="hover" aria-haspopup="true">
            '. $this->render('_a_parent', [
                'menu' => $menu,
            ]) .'
            
            <div class="menu-submenu menu-submenu-classic '. $subMenuClass .'">
                <ul class="menu-subnav">
                    '. $this->render('_link_creator', [
                        'menus' => $menu['sub'] ?? [],
                        'withIcon' => true,
                        'subMenuClass' => 'menu-submenu-right'
                    ]) .'
                </ul>
            </div>
        </li> 
    ',
    '
        <li class="menu-item '. ((Html::navController($menu['link']) == $controller) ? 'menu-item-active': '') .'" aria-haspopup="true">
            '. $this->render('_a_child', [
                'menu' => $menu,
                'withIcon' => $withIcon,
            ]) .'
        </li>
    ',
) ?>
 