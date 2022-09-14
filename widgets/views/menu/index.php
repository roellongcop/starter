<?php

use app\helpers\Html;
?>

<?= Html::if($menus, function() use ($menus, $viewParams) {
    return Html::tag('ul', 
        $this->render('_link_creator', [
            'menus' => $menus,
            'viewParams' => $viewParams,
        ]), [
        'class' => 'menu-nav'
    ]);
}) ?>