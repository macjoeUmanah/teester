<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  public function run()
  {
    $this->call([
      UsersTableSeeder::class,
      RolesTableSeeder::class,
      CountriesTableSeeder::class,
      PagesTableSeeder::class,
      SettingsTableSeeder::class,
    ]);
  }
}
