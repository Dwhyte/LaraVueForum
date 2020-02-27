<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use App\Models\Thread;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Thread::class, function (Faker $faker) {
   $title = $faker->text(26);
   $user = User::all()->random();
    return [
        'user_id' => $user->id,
        'cat_id' => Category::all()->random()->id,
        'username' => $user->username,
        'title' => $title,
        'slug' => Str::slug($title),
        'content' => $faker->sentences(3, true),
        'featured_image' => null,
        'isDraft' => 0
    ];
});
