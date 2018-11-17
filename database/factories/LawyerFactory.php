<?php

//use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(App\Models\Lawyer::class, function () {
	$faker = Faker\Factory::create('zh_CN');
	$now = Carbon::now()->toDateTimeString();

    return [
        'name' => $faker->name,
        'mobile' => $faker->unique()->phoneNumber,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
        'created_at' => $now,
        'updated_at' => $now,
    ];
});
