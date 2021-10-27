<?php

use app\helpers\Html;
?>

<?= Html::if($navigations, Html::foreach($navigations, function($key, $nav) use ($data_id) {
    $data_id = App::generateRandomKey($data_id ?? implode('-', [time(), rand(11111, 99999)]));
    return $this->render('_navigation-content', [
        'key' => $key,
        'nav' => $nav,
        'data_id' => $data_id,
    ])
})) ?>