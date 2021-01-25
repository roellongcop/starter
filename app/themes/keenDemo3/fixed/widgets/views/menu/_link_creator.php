<?php
use app\helpers\App;
use app\helpers\Element;
$controller = $this->params['controller'] ?? App::controllerID();
?>
<?php foreach ($menus as $menu): ?>
    <?php if (isset($menu['group_menu']) && $menu['group_menu']): ?>
        <li class="menu-section">
            <h4 class="menu-text"><?= $menu['label'] ?></h4>
            <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
        </li>
    <?php else: ?>
        <?php if (!empty($menu['sub'])): ?>
            <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                <?= $this->render('_a_parent', ['menu' => $menu]) ?>
                
                <div class="menu-submenu">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                        <?= $this->render('_link_creator', ['menus' => $menu['sub']]) ?>
                    </ul>
                </div>
            </li> 

        <?php else: ?>
            <li class="menu-item <?= (Element::navController($menu) == $controller) ? 'menu-item-active': '' ?>" aria-haspopup="true">
                <?= $this->render('_a_child', ['menu' => $menu]) ?>
            </li>
        <?php endif ?>
    <?php endif ?>
<?php endforeach ?>