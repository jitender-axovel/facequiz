<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        
        DB::table('users')->insert([
        	['first_name' => 'Jitender', 'last_name' => 'Singla', 'slug' => 'jitender-singla-1', 'user_role_id' => 1, 'email' => 'jitender.axovel@gmail.com', 'password' => Hash::make('admin123'), 'gender' => 'M', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
    	]);
    }
}
