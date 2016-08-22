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
        	['name' => 'SideBar', 'slug' => 'sidebar', 'preview_image' => 'sidebar.png', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        	['name' => 'Below Quizzes', 'slug' => 'belowquizzes', 'preview_image' => 'below-quizzes.png', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        	['name' => 'Above Quizzes', 'slug' => 'abovequizzes', 'preview_image' => 'above-quizzes.png', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        	['name' => 'Below Quiz View', 'slug' => 'belowquizview', 'preview_image' => 'below-quiz-view.png', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
    	]);
    }
}
