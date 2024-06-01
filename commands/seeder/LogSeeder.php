<?php

namespace app\commands\seeder;

use app\commands\models\Role;
use app\commands\models\Log;
use app\helpers\App;

class LogSeeder extends Seeder
{
	public $roles;
	public $modelClass = [
		'class' => 'app\commands\models\Log',
	];

	
	public function attributes()
	{
		$email = $this->faker->email;

		return [
			'user_id' => 1,
			'model_id' => 1,
			'request_data' => json_encode(["request_data"]),
			'change_attribute' => json_encode(["change_attribute"]),
			'method' => "method",
			'url' => "url",
			'action' => "action",
			'controller' => "controller",
			'table_name' => "table_name",
			'model_name' => "model_name",
			'server' => json_encode(["server"]),
			'ip' => "ip",
			'browser' => "browser",
			'os' => "os",
			'device' => "device",
			'created_by' => 1,
			'updated_by' => 1,
			'record_status' => 1,
		];
	}
}