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
			'class' => 'app\models\Role',
			'module_access' => $access->controllerActions(),
			'main_navigation' => $access->defaultNavigation(),
		];
	}

	public function attributes()
	{
		return [
            'name' => $this->faker->jobTitle, 
            'record_status' => $this->recordStatus(),
            'created_at' => $this->created_at(),
		];
	}
}