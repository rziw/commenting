<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use \App\Models\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'description' => $faker->text(500),
        'owner_id'  => auth()->id() ?? factory('App\User'),
        'category_id'  => factory('App\Models\Category')
    ];
});
