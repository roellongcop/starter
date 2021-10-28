<?= \app\helpers\Html::if($menus, 
    '<ul class="menu-nav">
        '. $this->render('_link_creator', ['menus' => $menus]) .'
    </ul>'
) ?>