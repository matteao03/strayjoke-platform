<?php

use Illuminate\Database\Seeder;
use App\Models\Lawyer;

class LawyersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //获取faker 实例
        //$faker = app(Faker\Generator::class);
    	$lawyers = factory(Lawyer::class)->times(10)->make()->each(function(){});
    	$lawyers_array= $lawyers->makeVisible(['password', 'remember_token'])->toArray();
    	Lawyer::insert($lawyers_array);
    }
}
