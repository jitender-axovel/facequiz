<?php

use Illuminate\Database\Seeder;

use App\Helper;

class CmsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cms')->delete();
    	$dt = new DateTime();
		$dt = $dt->format('Y-m-d H:i:s');
        DB::table('cms')->insert([
            ['title' => 'Privacy Policy', 'slug' => Helper::slug('Privacy Policy'), 'created_at' => $dt, 'updated_at' => $dt],
            ['title' => 'Terms & Conditions', 'slug' => Helper::slug('Terms & Conditions'), 'created_at' => $dt, 'updated_at' => $dt],
            ['title' => 'About Us', 'slug' => Helper::slug('About Us'), 'created_at' => $dt, 'updated_at' => $dt]
        ]);
    }
}
