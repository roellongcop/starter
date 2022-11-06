<?php

use app\helpers\Html;
?>

<?= Html::if($menus, function($menus) use($viewParams) {
    return Html::tag('ul', 
        $this->render('_link_creator', [
            'menus' => $menus,
            'viewParams' => $viewParams,
        ]), [
        'class' => 'menu-nav'
    ]);
}) ?>