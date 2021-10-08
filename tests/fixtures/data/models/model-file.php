<?php

use app\models\ModelFile;

$model = new \app\helpers\FixtureData(function($model_name) {
    return [
		'model_id' => 1,
		'file_id' => 1,
		'model_name' => $model_name,
		'extension' => 'jpg',
		'created_by' => 1,
		'updated_by' => 1,
	];
});

$model->add('user', 'User');
$model->add('backup', 'Backup', [
	'file_id' => 2,
	'extension' => 'sql',
]);
$model->add('inactive', 'Backup', [
	'model_id' => 2,
	'file_id' => 2,
	'extension' => 'sql',
    'record_status' => ModelFile::RECORD_INACTIVE,
]);

return $model->getData();