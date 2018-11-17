<?php

use Carbon\Carbon;

$factory->define(App\Models\Article::class, function () {
	$faker = Faker\Factory::create('zh_CN');
	$now = Carbon::now()->toDateTimeString();

    return [
        'title' => $faker ->text,
        'content' =>  $faker->sentence(),
        'created_at' => $now,
        'updated_at' => $now,
    ];
});
