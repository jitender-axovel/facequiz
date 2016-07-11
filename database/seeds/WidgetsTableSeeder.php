<?php

use Illuminate\Database\Seeder;

class WidgetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('widgets')->delete();
        
        DB::table('widgets')->insert([
        	['name' => 'SideBar', 'slug' => 'sidebar', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        	['name' => 'Below Quizzes', 'slug' => 'belowquizzes', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        	['name' => 'Above Quizzes', 'slug' => 'abovequizzes', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        	['name' => 'Below Quiz View', 'slug' => 'belowquizview', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
    	]);
    }
}
