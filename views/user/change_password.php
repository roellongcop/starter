<?php

use app\models\search\UserSearch;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Change Password';
$this->params['breadcrumbs'][] = 'Change Password';
$this->params['searchModel'] = new UserSearch();
?>

<div>
	<?= $this->render('_change_password', [
		'model' => $model,
	]) ?>
</div>