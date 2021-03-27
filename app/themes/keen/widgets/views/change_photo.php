<?php

use app\helpers\App;
use app\widgets\Dropzone;
use app\helpers\Html;
use app\helpers\Url;
$this->registerJs(<<< SCRIPT
	var disableButton = function() {
    	$('#change-photo-confirm-{$id}').prop('disabled', false);
	}

    var selectedFile = 0;
    $('.my-image-files').on('click', function() {
    	var image = $(this);

    	selectedFile = image.data('id');

    	$('.image-properties-panel #name').text(image.data('name'));
    	$('.image-properties-panel #extension').text(image.data('extension'));
        $('.image-properties-panel #size').text(image.data('size'));
        $('.image-properties-panel #width').text(image.data('width') + 'px');
    	$('.image-properties-panel #height').text(image.data('height') + 'px');
    	$('.image-properties-panel #location').text(image.data('location'));
    	$('.image-properties-panel #token').text(image.data('token'));
    	$('.image-properties-panel #created_by').text(image.data('created_by'));
    	$('.image-properties-panel #created_at').text(image.data('created_at'));

    	$('.my-image-files').removeClass('selected-image');
    	image.addClass('selected-image');
    	disableButton();
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
$this->registerCSS(<<<CSS
	.selected-image {
		border: 2px solid #1bc5bd;
	}
	.image-properties-panel {
		border-left: 2px solid #ddd;
	}
	.image-properties-panel .table-bordered th, .table-bordered td {
	    padding: 5px 5px;
	}
	.table-bordered td {
	    word-wrap:break-word;
	    max-width: 300px;
	}
	.image-properties-panel .table-bordered {
		table-layout: fixed;
	}
CSS);
?>

<!-- Button trigger modal-->
<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#change_photo-<?= $id ?>">
    <?= $buttonTitle ?>
</button>

<!-- Modal-->
<div class="modal fade" id="change_photo-<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
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
                <div >
	                <ul class="nav nav-tabs nav-bold nav-tabs-line">
	                    <li class="nav-item">
	                        <a class="nav-link active" data-toggle="tab" href="#my_files-<?= $id ?>">
	                            <span class="nav-icon">
	                            	<i class="flaticon2-files-and-folders"></i>
	                            </span>
	                            <span class="nav-text">My Photos</span>
	                        </a>
	                    </li>
	                    <li class="nav-item">
	                        <a class="nav-link" data-toggle="tab" href="#cp_dropzone-<?= $id ?>">
	                            <span class="nav-icon">
	                            	<i class="flaticon-upload"></i>
	                            </span>
	                            <span class="nav-text">Upload</span>
	                        </a>
	                    </li>
	                </ul>
					<div class="tab-content pt-10">
        				<div class="tab-pane fade show active" id="my_files-<?= $id ?>" role="tabpanel" aria-labelledby="my_files-<?= $id ?>">
        					<div class="row">
        						<div class="col-md-7 col-sm-6">
        							<?php if ($files): ?>
		        						<div class="row">
			        						<?php foreach ($files as $file): ?>
			                        			<div class="col-md-3">
			                        				<?= Html::img(['file/display', 'token' => $file->token, 'w' => 150, 'h' => 150, 'ratio' => 'false'], [
			                        					'class' => 'img-thumbnail pointer my-image-files',
			                        					'data-id' => $file->id,
			                        					'data-name' => $file->name,
			                        					'data-extension' => $file->extension,
                                                        'data-size' => $file->fileSize,
                                                        'data-width' => $file->width,
			                        					'data-height' => $file->height,
			                        					'data-location' => $file->location,
			                        					'data-token' => $file->token,
			                        					'data-created_by' => $file->createdByEmail,
			                        					'data-created_at' => App::formatter('asFulldate', $file->created_at),
			                        				]) ?>
			                        			</div>
			       							<?php endforeach; ?>
		        						</div>
		        					<?php endif ?>
        						</div>
        						<div class="col-md-5 col-sm-6 image-properties-panel">
        							<p class="lead text-warning">Image Properties</p>
        							<table class="table-bordered font-size-sm">
        								<tbody>
        									<tr>
        										<th>Name</th>
        										<td id="name"> None </td>
        									</tr>
        									<tr>
        										<th>Extension</th>
        										<td id="extension"> None </td>
        									</tr>
        									<tr>
        										<th>Size</th>
        										<td id="size"> None </td>
        									</tr>
                                            <tr>
                                                <th>Width</th>
                                                <td id="width"> None </td>
                                            </tr>
                                            <tr>
                                                <th>Height</th>
                                                <td id="height"> None </td>
                                            </tr>
        									<tr>
        										<th>Location</th>
        										<td id="location"> None </td>
        									</tr>
        									<tr>
        										<th>Token</th>
        										<td id="token"> None </td>
        									</tr>
        									<tr>
        										<th>Created By</th>
        										<td id="created_by"> None </td>
        									</tr>
        									<tr>
        										<th>Created At</th>
        										<td id="created_at"> None </td>
        									</tr>
        								</tbody>
        							</table>
        						</div>
        					</div>
        					
	        			</div>
        				<div class="tab-pane fade" id="cp_dropzone-<?= $id ?>" role="tabpanel" aria-labelledby="cp_dropzone-<?= $id ?>">
							<?= Dropzone::widget([
						        'model' => $model,
						        'maxFiles' => 1,
						        'removedFile' => '//',
						        'complete' => $dropzoneComplete,
						        'acceptedFiles' => array_map(
						            function($val) { 
						                return ".{$val}"; 
						            }, App::params('file_extensions')['image']
						        )
						    ]) ?>
	        			</div>
	        		</div>
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