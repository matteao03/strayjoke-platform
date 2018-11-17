<?php

use Illuminate\Database\Seeder;
use App\Models\Topic;

class TopicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_ids = ['1', '2', '3', '4', '5'];
        $faker = app(Faker\Generator::class);

        $topics = factory(Topic::class)->times(10)->make()->each(function($topic, $index)
        	use ($user_ids, $faker)
        	{
        		$topic->user_id = $faker->randomElement($user_ids);
        	});

        Topic::insert($topics->toArray());
    }
}
