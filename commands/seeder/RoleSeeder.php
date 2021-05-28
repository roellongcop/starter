<?php
namespace app\commands\seeder;

use app\helpers\App;
class RoleSeeder extends Seeder
{
	public $modelClass = '\app\models\Role';
	public $controllerActions;
	public $defaultNavigation;

	public function __construct()
	{
		parent::__construct();
		$access = App::component('access');

		$this->controllerActions = $access->controllerActions();
		$this->defaultNavigation = $access->defaultNavigation();
	}

	public function attributes()
	{
		return [
            'name' => $this->faker->jobTitle, 
            'module_access' => $this->controllerActions,
            'main_navigation' => $this->defaultNavigation,
            'record_status' => $this->recordStatus(),
            'created_at' => $this->created_at(),
		];
	}
}