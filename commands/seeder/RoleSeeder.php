<?php
namespace app\commands\seeder;

use app\helpers\App;
class RoleSeeder extends Seeder
{
	public $controllerActions;
	public $defaultNavigation;

	public function __construct()
	{
		parent::__construct();
		$this->controllerActions = App::component('access')->controllerActions();
		$this->defaultNavigation = App::component('access')->defaultNavigation();
	}
	public function modelClass()
	{
		return '\app\models\Role';
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