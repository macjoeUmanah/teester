<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
  public function run()
  {
    // if error about foreign key
    try{
      DB::table('users')->truncate();
    } catch(\Exception $e) {}
    try{
      DB::table('users')->insert([
        'name' => 'MailCarry',
        'email' => 'admin@mailcarry.com',
        'password' => bcrypt('admin123'),
        'api_token' => str_random(60),
        'role_id' => 1,
        'app_id' => 1,
        'created_at' => now(),
        'updated_at' => now()
      ]);
    } catch(\Exception $e) {}
  }
}
