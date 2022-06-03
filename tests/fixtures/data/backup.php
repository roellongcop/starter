<?php

use app\models\Backup;
use yii\helpers\Inflector;
use yii\db\Expression;

$model = new \app\helpers\FixtureData(function($filename) {
	$dbPref = \Yii::$app->db->tablePrefix;
    return [
		'filename' => $filename,
		'tables' => json_encode([
		   "{$dbPref}backups" => "{$dbPref}backups",
		   "{$dbPref}files" => "{$dbPref}files",
		   "{$dbPref}ips" => "{$dbPref}ips",
		   "{$dbPref}logs" => "{$dbPref}logs",
		   "{$dbPref}migrations" => "{$dbPref}migrations",
		   "{$dbPref}notifications" => "{$dbPref}notifications",
		   "{$dbPref}queues" => "{$dbPref}queues",
		   "{$dbPref}roles" => "{$dbPref}roles",
		   "{$dbPref}sessions" => "{$dbPref}sessions",
		   "{$dbPref}settings" => "{$dbPref}settings",
		   "{$dbPref}themes" => "{$dbPref}themes",
		   "{$dbPref}user_metas" => "{$dbPref}user_metas",
		   "{$dbPref}users" => "{$dbPref}users",
		   "{$dbPref}visit_logs" => "{$dbPref}visit_logs",
		]),
		'description' => 'Description',
		'slug' => (string) Inflector::slug($filename),
		'record_status' => Backup::RECORD_ACTIVE,
		'created_by' => 1,
	    'updated_by' => 1,
		'created_at' => new Expression('UTC_TIMESTAMP'),
        'updated_at' => new Expression('UTC_TIMESTAMP'),
	    'sql' => 'default-OxFBeC2Dzw1624513904-default'
	];
});

$model->add('first-backup', 'first-backup');
$model->add('inactive', 'Inactive', ['record_status' => Backup::RECORD_INACTIVE]);

return $model->getData();