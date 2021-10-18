<?php

namespace app\commands\seeder;

use app\commands\models\Role;
use app\commands\models\User;
use app\helpers\App;

class UserSeeder extends Seeder
{
	public $roles;
	public $modelClass = [
		'class' => 'app\commands\models\User',
		'password_hint' => 'Same as Email',
	];

	public function __construct()
	{
		parent::__construct();
		$this->roles = array_keys(Role::dropdown());
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
            'status' => $this->faker->randomElement([
	            User::STATUS_DELETED,
	            User::STATUS_INACTIVE,
	            User::STATUS_ACTIVE,
	        ]),
            'record_status' => $this->recordStatus(),
            'is_blocked' => $this->faker->randomElement([
	            User::BLOCKED,
	            User::UNBLOCKED,
	        ]),
            'created_at' => $created_at,
            'updated_at' => $created_at,
		];
	}
}