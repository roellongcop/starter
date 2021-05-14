<?php

use app\helpers\App;
use app\widgets\Dropzone;
use app\helpers\Html;
use app\helpers\Url;
$this->registerJs(<<< SCRIPT
	var enableButton = function() {
    	$('#change-photo-confirm-{$id}').prop('disabled', false);
	}

    var selectedFile = 0;
    $(document).on('click', '#my_files-{$id} img', function() {
    	var image = $(this);

    	selectedFile = image.data('id');

    	$('#change-photo-container-{$id} #{$id}-name').text(image.data('name'));
        $('#change-photo-container-{$id} #{$id}-extension').text(image.data('extension'));
        $('#change-photo-container-{$id} #{$id}-size').text(image.data('size'));
        $('#change-photo-container-{$id} #{$id}-width').text(image.data('width') + 'px');
        $('#change-photo-container-{$id} #{$id}-height').text(image.data('height') + 'px');
        $('#change-photo-container-{$id} #{$id}-location').text(image.data('location'));
        $('#change-photo-container-{$id} #{$id}-token').text(image.data('token'));
        $('#change-photo-container-{$id} #{$id}-created_at').text(image.data('created_at'));

    	$('#change-photo-container-{$id} #my_files-{$id} img').css('border', '');
        image.css('border', '2px solid #1bc5bd');
    	enableButton();
	})

	$('#change-photo-confirm-{$id}').on('click', function() {
		$.ajax({
            url: '{$changePhotoUrl}',
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
	});


    var getMyFiles = function(url) {
        $('#my_files-{$id} .modal-my-photos').html('');
        KTApp.block('#my_files-{$id} .modal-my-photos', {
            overlayColor: '#000000',
            message: 'Loading Images...',
            state: 'primary' // a bootstrap color
        });

        let conf = {
            url: url,
            method: 'get',
            cache: false,
            success: function(s) {
                $('#my_files-{$id} .modal-my-photos').html(s);
                KTApp.unblock('#my_files-{$id} .modal-my-photos');
            },
            error: function(e) {
                KTApp.unblock('#my_files-{$id} .modal-my-photos');
            }
        }   

        $.ajax(conf);
    }

    $('#change_photo-btn-{$id}').on('click', function() {
        getMyFiles('{$myImageFilesUrl}');
    })


    $(document).on('click', '#my_files-{$id} .modal-my-photos a.btn', function() {
        let href = $(this).attr('href')

        getMyFiles(href)
        return false;    
    });


SCRIPT, \yii\web\View::POS_END);
$this->registerCSS(<<<CSS
	#change-photo-container-{$id} table tbody tr td {
        overflow-wrap: anywhere;
        padding: 5px;
    }
    #change-photo-container-{$id} table tbody tr th {
        padding: 5px;
    }

    #change-photo-container-{$id} .d-flex {
        display: grid !important;
        width: fit-content !important;
    }
    #my_files-{$id} img:hover {
        border: 2px solid #1bc5bd;
    }
CSS);
?>

<div id="change-photo-container-<?= $id ?>">
    <!-- Button trigger modal-->
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#change_photo-<?= $id ?>" id="change_photo-btn-<?= $id ?>">
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
            						<div class="col-md-7 col-sm-6" style="border-right: 1px dashed #ccc">
                                        <div class="modal-my-photos">
                							
                                        </div>
            						</div>
            						<div class="col-md-5 col-sm-6 image-properties-panel">
            							<p class="lead text-warning">Image Properties</p>
            							<table class="table-bordered font-size-sm">
            								<tbody>
            									<tr>
            										<th>Name</th>
            										<td id="<?= $id ?>-name"> None </td>
            									</tr>
            									<tr>
            										<th>Extension</th>
            										<td id="<?= $id ?>-extension"> None </td>
            									</tr>
            									<tr>
            										<th>Size</th>
            										<td id="<?= $id ?>-size"> None </td>
            									</tr>
                                                <tr>
                                                    <th>Width</th>
                                                    <td id="<?= $id ?>-width"> None </td>
                                                </tr>
                                                <tr>
                                                    <th>Height</th>
                                                    <td id="<?= $id ?>-height"> None </td>
                                                </tr>
            									<tr>
            										<th>Location</th>
            										<td id="<?= $id ?>-location"> None </td>
            									</tr>
            									<tr>
            										<th>Token</th>
            										<td id="<?= $id ?>-token"> None </td>
            									</tr>
            									<tr>
            										<th width="30%">Created At</th>
            										<td id="<?= $id ?>-created_at"> None </td>
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
    						        'complete' => "
                                        {$dropzoneComplete}

                                        $('#change_photo-{$id}').modal('hide')
                                    ",
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
</div>