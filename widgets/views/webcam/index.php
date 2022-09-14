<?php

use app\helpers\Html;
use yii\helpers\Html AS YiiHtml;

$this->registerWidgetJs($widgetFunction, <<< JS
	let video = document.querySelector("#{$videoOptions['id']}");
	let click_button = document.querySelector("#{$buttonOptions['id']}");
	let canvas = document.querySelector("#{$canvasOptions['id']}");
	let loading = document.querySelector("#webcam-container-{$widgetId} .loading");

	let initCamera = async function() {
	   	let stream = null;

	    try {
	    	stream = await navigator.mediaDevices.getUserMedia({ 
	    		video:  {width: {$videoOptions['width']}, height: {$videoOptions['height']}, facingMode: "user"}, 
	    		audio: false, 
    		});
	    	let settings = stream.getTracks()[0].getSettings();

	    	// stream.getTracks()[0].applyConstraints({ advanced : [{ brightness: 20 }] });

	    	// let getCapabilities = stream.getTracks()[0].getCapabilities();
	    	// console.log(getCapabilities)

	    	canvas.width = settings.width
	    	canvas.height = settings.height
	    }
	    catch(e) {
            toastr.error(e.message);
	    	return;
	    }

	    video.srcObject = stream;


	    video.style.display = 'block';
	    click_button.style.display = 'block';
	    loading.style.display = 'none';
	}
	initCamera();

	click_button.addEventListener('click', function() {
		KTApp.block('#webcam-container-{$widgetId}', {
			overlayColor: '#000000',
			state: 'primary',
			message: 'Uploading...'
		});
	    canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
	   	let blobData = canvas.toBlob(function(blob) {
	   		const formData = new FormData();
	   		let modelName = $('#webcam-container-{$widgetId} .model-name-input').val();
	   		modelName = (modelName)? modelName: '{$modelName}-webcam-' + Date.now();

	    	formData.append('UploadForm[tag]', '{$tag}');
	    	formData.append('UploadForm[modelName]', '{$modelName}');
        	formData.append('UploadForm[fileInput]', blob, modelName + '.jpeg');

	        $.ajax({
	    		url: app.baseUrl + 'file/upload',
	            method: 'POST',
	            data: formData,
	            processData: false,
	            contentType: false,
	            dataType: 'json',
	            success: function(s) {
	                if(s.status == 'success') {
	                   	{$ajaxSuccess}
	                   	$('#webcam-container-{$widgetId} .model-name-input').val('');
	                }
	                else {
	                    alert(s.message);
	                }
					KTApp.unblock('#webcam-container-{$widgetId}');
	            },
	            error:function(e) {
	                alert(e.responseText);
					KTApp.unblock('#webcam-container-{$widgetId}');
	            },
	        });
	   	}, 'image/jpeg');

	});
JS, \yii\web\View::POS_END);

?>

<div id="webcam-container-<?= $widgetId ?>">
	<div class="loading">Camera is loading...</div>
	<?= Html::tag('video', '', $videoOptions) ?>

	<?= Html::if($withNameInput, Html::input('text', 'modelName', '', [
		'class' => 'model-name-input form-control mt-3',
		'placeholder' => 'Enter File name',
		'required' => true
	])) ?>

	<?= YiiHtml::a($buttonOptions['value'], '#webcam-container-' . $widgetId, $buttonOptions) ?>

	<?= Html::tag('canvas', '', $canvasOptions) ?>
    <?= Html::if($withInput, function() use($model, $attribute) {
    	return Html::activeInput('hidden', $model, $attribute, [
	    	'class' => 'webcam-file-input'
	    ]);
    }) ?>
</div>


