<?php
use yii\helpers\Inflector;

$dbPref = \Yii::$app->db->tablePrefix;

return [
	'first-backup' => [
		'filename' => 'first-backup',
		'tables' => json_encode([
		   "{$dbPref}backups" => "{$dbPref}backups",
		   "{$dbPref}files" => "{$dbPref}files",
		   "{$dbPref}ips" => "{$dbPref}ips",
		   "{$dbPref}logs" => "{$dbPref}logs",
		   "{$dbPref}migrations" => "{$dbPref}migrations",
		   "{$dbPref}model_files" => "{$dbPref}model_files",
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
		'slug' => (string) Inflector::slug('first-backup'),
		'created_by' => 1,
	    'updated_by' => 1,
	]
];