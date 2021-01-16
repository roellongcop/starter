<?php

use app\widgets\Dropzone;
use yii\helpers\Html;
$this->registerJs(<<< SCRIPT
    var selectedFile = 0;
    $('.my-image-files').on('click', function() {
    	selectedFile = $(this).data('id');
    	$('.my-image-files').css('border', '');
    	$(this).css('border', '2px solid #1bc5bd');
    	$('#change-photo-confirm-{$id}').prop('disabled', false)
	})

	$('#change-photo-confirm-{$id}').on('click', function() {
		$.ajax({
			url: '{$uploadUrl}',
			data: {
				file_id: selectedFile,
				model_id: {$model_id},
				modelName: '{$modelName}',
			},
			method: 'post',
			dataType: 'json',
			success: {$ajaxSuccess},
			error: {$ajaxError},
		})
	})
SCRIPT, \yii\web\View::POS_END);
?>

<!-- Button trigger modal-->
<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#change_photo-<?= $id ?>">
    <?= $buttonTitle ?>
</button>

<!-- Modal-->
<div class="modal fade" id="change_photo-<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
    				<?= $modelTitle ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div data-scroll="true" data-height="500">
                	<?php if ($files): ?>
						<div class="row">
    						<?php foreach ($files as $file): ?>
                    			<div class="col-md-2">
                    				<?= Html::img(['file/display', 'token' => $file->token, 'w' => 150], [
                    					'class' => 'img-thumbnail pointer my-image-files',
                    					'data-id' => $file->id,
                    				]) ?>
                    			</div>
   							<?php endforeach; ?>
						</div>
					<?php endif ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                <button 
                	data-dismiss="modal"
	                disabled="disabled"
                	type="button" 
                	class="btn btn-primary font-weight-bold"
                	id="change-photo-confirm-<?= $id ?>">
                		Confirm
            	</button>
            </div>
        </div>
    </div>
</div>