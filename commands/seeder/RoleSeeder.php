<?php

namespace app\commands\seeder;

use app\helpers\App;
class RoleSeeder extends Seeder
{
	public function __construct()
	{
		parent::__construct();
		$access = App::component('access');

		$this->modelClass = [
			'class' => 'app\commands\models\Role',
			'module_access' => $access->controllerActions,
			'main_navigation' => $access->defaultNavigation,
		];
	}

	public function attributes()
	{
		$created_at = $this->created_at();
		return [
            'name' => $this->faker->jobTitle, 
            'record_status' => $this->recordStatus(),
            'created_at' => $created_at,
            'updated_at' => $created_at,
		];
	}
}