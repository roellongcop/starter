<?php

use app\helpers\Html;
use app\widgets\ImageGallery;
?>
<?= ImageGallery::widget([
    'tag' => 'Setting',
    'model' => $model,
    'attribute' => 'value',
    'ajaxSuccess' => "
        if(s.status == 'success') {
            KTApp.block('#sipc', {
                overlayColor: '#000000',
                state: 'primary',
                message: 'Processing...'
            });

            setTimeout(function() {
                KTApp.unblock('#sipc');
            }, 1000);
            $('#sipc img').attr('src', s.src + '&w=200')
        }
    ",
]) ?> 
<br>
<div id="sipc" style="max-width: 200px">
    <?= Html::image($model->value, ['w' => 200], [
        'id' => 'setting-imageinput-preview',
        'class' => 'img-thumbnail',
        'loading' => 'lazy'
    ]) ?>
</div>