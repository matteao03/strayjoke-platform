<?php

use Illuminate\Database\Seeder;
use App\Models\Lawyer;
use App\Models\Article;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$lawyer_ids = Lawyer::all()->pluck('id')->toArray();
    	$faker = app(Faker\Generator::class);

        $Articles = factory(Article::class)->times(10)->make()->each(function($article, $index)
        	use ($lawyer_ids, $faker)
        	{
        		$article ->lawyer_id = $faker->randomElement($lawyer_ids);
        	});
    	
    	Article::insert($Articles->toArray());
    }
}
