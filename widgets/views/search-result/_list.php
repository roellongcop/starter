<?php
use app\helpers\App;
use app\widgets\Anchors;
?>
<div class="card">
	<div class="card-header">
		<div class="card-title collapsed" 
			data-toggle="collapse" 
			data-target="#<?= $module ?>-tab-<?= $model->id ?>" 
			aria-expanded="false">
			<?= $index + 1 ?>) 

			<?= $model->mainAttribute ?>
			&nbsp; 
			<small>
				(<?= App::formatter('asFulldate', $model->created_at) ?>)
			</small>
		</div>
	</div>
	<div id="<?= $module ?>-tab-<?= $model->id ?>" class="collapse" data-parent="#<?= $module ?>" style="">
		<div class="card-body">
			<p>
				<?= Anchors::widget([
			    	'names' => ['view', 'update', 'duplicate', 'delete', 'log'], 
			    	'model' => $model,
			    ]) ?> 
			</p>
			<?= $model->detailView ?>
		</div>
	</div>
</div>