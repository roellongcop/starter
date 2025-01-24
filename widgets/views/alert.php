<?php

use app\widgets\Reminder;
?>

<?= Reminder::widget([
    'head' => $key == 'danger' ? 'Error': ucwords($key),
    'message' => $alertMessage,
    'type' => $key,
    'withDot' => false
]) ?>
