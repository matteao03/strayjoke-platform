<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
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
    	$users = factory(User::class)->times(10)->make()->each(function(){});
    	$users_array= $users->makeVisible(['password', 'remember_token'])->toArray();
    	User::insert($users_array);

    }
}
