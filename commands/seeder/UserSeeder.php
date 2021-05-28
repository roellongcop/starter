<?php
namespace app\commands\seeder;

use app\helpers\App;
use app\models\Role;


class UserSeeder extends Seeder
{
	public $roles;
	public $modelClass = '\app\models\User';

	public function __construct()
	{
		parent::__construct();
		$this->roles = array_keys(Role::dropdown());
	}

	public function attributes()
	{
		$email = $this->faker->email;

		return [
           	'role_id' => $this->faker->randomElement($this->roles),
            'username' => $this->faker->firstName,
            'email' => $email,
            'password_hash' => App::hash($email),
            'password_hint' => 'Same as Email',
            'status' => $this->randomParamsID('user_status'),
            'record_status' => $this->randomParamsID('record_status'),
            'is_blocked' => $this->randomParamsID('is_blocked'),
            'created_at' => $this->created_at(),
		];
	}
}