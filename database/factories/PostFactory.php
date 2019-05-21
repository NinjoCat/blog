<?php
use Faker\Generator as Faker;

$factory->define(App\Rubric::class, function ($faker) {
    return [
        'name' => $faker->title
    ];
});

$factory->define(App\Revision::class, function ($faker) {
    return [
        'title' => $faker->title,
        'text' => $faker->text,
        'status' => App\Revision::STATUS['INACTIVE']
    ];
});

$factory->define(App\Tag::class, function ($faker) {
    return [
        'name' => $faker->title
    ];
});

$factory->define(App\Post::class, function ($faker) {
    return [
        'user_id' =>  function () {
            return factory(App\User::class)->create()->id;
        },
        'rubric_id' => function () {
            return factory(App\Rubric::class)->create()->id;
        },
    ];
});


