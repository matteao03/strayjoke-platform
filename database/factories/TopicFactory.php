<?php

use Carbon\Carbon;

$factory->define(App\Models\Topic::class, function () {
	$faker = Faker\Factory::create('zh_CN');
	$now = Carbon::now()->toDateTimeString();

    return [
        'content' => $faker->text,
        'created_at' => $now,
        'updated_at' => $now,
    ];
});
