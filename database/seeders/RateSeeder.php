<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Rate;

class RateSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$rates = [
			[
				'provider_id' => 1,
				'rate' => 0.90,
				'pulsa' => 10000,
				'uang' => 9000,
			],
			[
				'provider_id' => 2,
				'rate' => 0.90,
				'pulsa' => 10000,
				'uang' => 9000,
			],
			[
				'provider_id' => 3,
				'rate' => 0.90,
				'pulsa' => 10000,
				'uang' => 9000,
			],
			[
				'provider_id' => 4,
				'rate' => 0.90,
				'pulsa' => 10000,
				'uang' => 9000,
			],
		];

		foreach ($rates as $rate)
			Rate::create($rate);
	}
}
