<?php

use app\helpers\App;
use app\helpers\Html;
?>

<?= Html::if($navigations,
    function() use($navigations, $data_id, $id) {
        return Html::foreach($navigations, function($nav, $key) use ($data_id, $id) {
            $data_id = App::generateRandomKey($data_id);
            return $this->render('_navigation-content', [
                'key' => $key,
                'nav' => $nav,
                'data_id' => $data_id,
                'id' => $id,
            ]);
        });
    }
) ?>