<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

$factory->define(Post::class, function (Faker $faker) {
    $title=$faker->realText(20);
    return [
        'title'=>$title,
        'content'=>$faker->text(50),
        'slug'=>Str::slug($title,'-'),
        'active'=>$faker->boolean(),
        'updated_at'=>$faker->dateTimeBetween('-3 years')
    ];
});
