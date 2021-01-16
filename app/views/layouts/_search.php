<?php

use app\helpers\App;
use app\models\search\DashboardSearch;
use app\widgets\Search;
use yii\widgets\ActiveForm;
$searchModel = $this->params['searchModel'] ?? '';
$searchTemplate = $searchModel->searchTemplate ?? "/".App::controllerID()."/_search";
$searchAction = $searchModel->searchAction ?? ['index'];
?>

<?php if ($searchModel): ?>
	<div class="row">
		<div class="col-md-4">
			<?php $form = ActiveForm::begin(['action' => $searchAction, 'method' => 'get']); ?>
			    <?= Search::widget(['model' => $searchModel]) ?>
		    <?php ActiveForm::end(); ?>
		</div>
		<div class="col-md-2">
			<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#advanced_saerch_modal">
				Advanced Search
			</button>
		</div>
	</div>
	
	
	<div id="advanced_saerch_modal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Advanced Search</h4>
				</div>
				<div class="modal-body">
					<?= $this->render("/{$searchTemplate}", ['model' => $searchModel]) ?> 
				</div>
			</div>
		</div>
	</div>
    
<?php endif ?>