<?php foreach(Yii::$app->session->getAllFlashes() as $key => $message) : ?>
    <div class="alert alert-custom alert-light-<?= $key ?> fade show mb-5" role="alert">
	    <div class="alert-text">
	    	<?= (is_array($message))? json_encode($message): $message ?>
	    </div>
	    <div class="alert-close">
	        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	            <span aria-hidden="true"><i class="ki ki-close"></i></span>
	        </button>
	    </div>
	</div>
<?php endforeach ?>