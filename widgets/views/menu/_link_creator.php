<?php

use app\helpers\App;
use app\helpers\Html;

$controller = $this->params['controller'] ?? App::controllerID();
?>

<?= Html::foreach($menus, function($menu) use ($controller) {
    return Html::ifElse(isset($menu['group_menu']) && $menu['group_menu'],
        function() use($menu) {
            return <<< HTML
                <li class="menu-section">
                    <h4 class="menu-text">{$menu['label']}</h4>
                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                </li>
            HTML;
        },
        Html::ifElse(!empty($menu['sub']),
            function() use ($menu) {
                $parent = $this->render('_a_parent', ['menu' => $menu]);
                $sub = $this->render('_link_creator', ['menus' => $menu['sub'] ?? []]);

                return <<< HTML
                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                        {$parent}
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                {$sub}
                            </ul>
                        </div>
                    </li>
                HTML;
            },
            function() use($menu, $controller) {
                $child = $this->render('_a_child', ['menu' => $menu]);
                $class = (Html::navController($menu['link']) == $controller)? 'menu-item-active': '';

                return <<< HTML
                    <li class="menu-item {$class}" aria-haspopup="true">
                        {$child}
                    </li>
                HTML;
            }
        )
    );
}) ?>