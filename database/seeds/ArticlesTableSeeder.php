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
    	$faker = app(Faker\Generator::class);

        $Articles = factory(Article::class)->times(10)->make();
    	
    	Article::insert($Articles->toArray());
    }
}
