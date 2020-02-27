<?php

use App\Models\Thread;
use Illuminate\Database\Seeder;

class ThreadsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //the number of threads we want to create - (50)
        factory(Thread::class, 50)->create();
    }
}
