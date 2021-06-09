<?php
use app\helpers\App;
use app\widgets\Anchor;
use yii\helpers\Html;
use yii\helpers\Url;

$registerJs = <<< SCRIPT
    var removeImage = function(self) {
        var file_id = $(self).data('file_id');
        var result = confirm('Remove Image?');
        if(result) {
            $.ajax({
                url: '{$removeImagePath}',
                data: {
                    file_id: file_id,
                    model_id: {$model->id},
                    model_name: '{$modelName}'
                },
                method: 'post',
                dataType: 'json',
                success: function(s) {
                    if(s.status == 'success') {
                        alert(s.message)
                        $('div[data-file_id="'+file_id+'"]').remove();
                    }
                    else {
                        alert(s.message)
                    }
                },
                error: function(e) {
                    alert(e.responseText)
                }    
            })
        } 
    }
SCRIPT;
$this->registerJs($registerJs, \yii\web\View::POS_END);
?>
<div class="row">
    <?php if($files): ?>
        <?php foreach ($files as $file): ?>
            <div class="col-md-3" data-file_id="<?= $file->id ?>">
                <div class="image-input">
                    <?php if (in_array($file->extension, App::params('file_extensions')['image'])): ?>
                        <?php $href = Url::to(['file/display', 'token' => $file->token], true) ?>
                    <?php else: ?>
                        <?php $href = Url::to(['file/download', 'token' => $file->token], true) ?>
                    <?php endif ?>
                        <a href="<?= $href ?>" target="_blank">
                        <?= $file->getPreviewIcon(300) ?>
                    </a>
                    <?php if (App::component('access')->userCanRoute($removeImageUrl)): ?>
                        <?= Anchor::widget([
                            'tooltip' => 'Remove Image',
                            'title' => '<i class="fa fa-trash icon-sm text-danger"></i>',
                            'link' => '#!',
                            'options' => [
                                'class' => 'btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow',
                                'data-action' => 'change',
                                'data-toggle' => 'tooltip',
                                'data-original-title' => 'Remove Image',
                                'data-file_id' => $file->id,
                                'onclick' => 'removeImage(this)'
                            ]
                        ]) ?>
                    <?php endif ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif ?>
</div>