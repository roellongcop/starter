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
        $class = Html::ifElse($viewParams['activeMenuLink'] ?? false, function($activeMenuLink) use($menu) {
            return ($activeMenuLink == $menu['link']) ? 'menu-item-active': '';
        }, function() use($menu, $controller) {
            list($c, $a) = App::app()->createController($menu['link']);
            $controllerId = $c ? $c->id: '';
            return ($controllerId == $controller)? 'menu-item-active': '';
        });

        $child = $this->render('_a_child', [
            'menu' => $menu,
            'withIcon' => $withIcon,
        ]);

        return <<< HTML
            <li class="menu-item {$class}" aria-haspopup="true"> {$child} </li>
        HTML;
    }
) ?>
 