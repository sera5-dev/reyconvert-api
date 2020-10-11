<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Provider;

class ProviderSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$providers = [
			[
				'nama' => 'telkomsel'
			],
			[
				'nama' => 'indosat'
			],
			[
				'nama' => 'xl axiata'
			],
			[
				'nama' => 'three'
			],
		];

		foreach ($providers as $provider)
			Provider::create($provider);
	}
}
