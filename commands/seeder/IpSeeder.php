<?php

namespace app\commands\seeder;

use app\commands\models\Ip;

class IpSeeder extends Seeder
{
	public $modelClass = 'app\commands\models\Ip';

	public function attributes()
	{
		$created_at = $this->created_at();

		return [
            'name' => $this->faker->ipv4,
            'description' => $this->faker->text,
            'type' => $this->faker->randomElement([
	            Ip::TYPE_BLACKLIST,
	            Ip::TYPE_WHITELIST,
	        ]),
            'record_status' => $this->recordStatus(),
            'created_at' => $created_at,
            'updated_at' => $created_at,
		];
	}
}