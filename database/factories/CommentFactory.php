<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {

    $user = factory('App\User')->create();

    return [
        'description' => $faker->text(),
        'post_id' => factory('App\Models\Post'),
        'user_id' => auth()->id() ?? $user->id,
        'user_name' => auth()->user()->name ?? $user->name
    ];
});
