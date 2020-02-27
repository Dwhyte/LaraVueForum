<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //the number of users we want to create - (30)
        factory(App\User::class, 30)->create();
    }
}
