<?php

use app\helpers\App;
use app\helpers\Html;
use app\helpers\Url;

$controller = $this->params['controller'] ?? App::controllerID();
?>

<?= Html::foreach($menus, function($menu) use ($controller, $viewParams) {
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
            function() use ($menu, $viewParams) {
                $parent = $this->render('_a_parent', [
                    'menu' => $menu,
                    'viewParams' => $viewParams
                ]);
                $sub = $this->render('_link_creator', [
                    'menus' => $menu['sub'] ?? [],
                    'viewParams' => $viewParams
                ]);

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
            function() use($menu, $controller, $viewParams) {
                $child = $this->render('_a_child', [
                    'menu' => $menu,
                    'viewParams' => $viewParams,
                ]);

                $class = Html::if($viewParams['activeMenuLink'] ?? $viewParams['controllerLink'], function($activeMenuLink) use($menu) {

                    $url = filter_var($menu['link'] ?? '', FILTER_VALIDATE_URL)? $menu['link']: Url::toRoute($menu['link']);

                    return ($activeMenuLink == $url) ? 'menu-item-active': '';
                });
                return <<< HTML
                    <li class="menu-item {$class}" aria-haspopup="true">
                        {$child}
                    </li>
                HTML;
            }
        )
    );
}) ?>