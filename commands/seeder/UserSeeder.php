<?php
namespace app\commands\seeder;

use app\helpers\App;
use app\models\Role;


class UserSeeder extends Seeder
{
	public $roles;

	public function __construct()
	{
		parent::__construct();
		$this->modelClass = [
			'class' => 'app\commands\models\User',
			'password_hint' => 'Same as Email',
		];

		$this->dependSeeder = [
			'class' => 'app\commands\seeder\RoleSeeder',
			'rows' => 5,
		];
	}

	public function afterDepend()
	{
		$this->roles = array_keys(Role::dropdown());
		parent::afterDepend();
	}

	public function attributes()
	{
		$email = $this->faker->email;
		$created_at = $this->created_at();

		return [
           	'role_id' => $this->faker->randomElement($this->roles),
            'username' => $this->faker->firstName,
            'email' => $email,
            'password_hash' => App::hash($email),
            'status' => $this->randomParamsID('user_status'),
            'record_status' => $this->randomParamsID('record_status'),
            'is_blocked' => $this->randomParamsID('is_blocked'),
            'created_at' => $created_at,
            'updated_at' => $created_at,
		];
	}
}