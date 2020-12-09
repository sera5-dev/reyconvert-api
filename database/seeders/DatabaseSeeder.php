<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->call([
      ProviderSeeder::class,
      RateSeeder::class,
    ]);

    User::create([
      'email' => 'admin@sera5.id',
      'username' => 'admin',
      'password' => md5('admin'),
      'nama' => 'admin',
    ]);
  }
}
