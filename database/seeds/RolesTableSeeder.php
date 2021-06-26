<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
  public function run()
  {
    DB::table('roles')->insert([
      'name' => 'SuperAdmin',
      'app_id' => 1,
      'user_id' => 1,
      'guard_name' => 'web',
      'created_at' => now(),
      'updated_at' => now()
    ]);


    DB::table('model_has_roles')->truncate();
    DB::table('model_has_roles')->insert([
      'role_id' => '1',
      'model_type' => 'App\Models\User',
      'model_id' => 1
    ]);
  }
}
