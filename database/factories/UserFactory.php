<?php

//use Faker\Generator as Faker;
use Carbon\Carbon;
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\User::class, function () {
	$faker = Faker\Factory::create('zh_CN');
	$now = Carbon::now()->toDateTimeString();

    return [
        'name' => $faker->name,
        'mobile' => $faker->unique()->phoneNumber,
        'password' => bcrypt('secret'), // secret
        'remember_token' => str_random(10),
        'created_at' => $now,
        'updated_at' => $now,
        'active' => 1,
        'nickname' => 'test',
        'wx_openid' => 'sdfaghjk12345',
    ];
});
