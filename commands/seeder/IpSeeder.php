<?php
namespace app\commands\seeder;

class IpSeeder extends Seeder
{
	public function modelClass()
	{
		return '\app\models\Ip';
	}

	public function attributes()
	{
		return [
            'name' => $this->faker->ipv4,
            'description' => $this->faker->text,
            'type' => $this->randomParamsID('ip_type'),
            'record_status' => $this->recordStatus(),
            'created_at' => $this->created_at(),
		];
	}
}