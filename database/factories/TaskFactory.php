<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Task::class, function (Faker $faker) {
    return [
        'name'   => $faker->sentence,
        'status' => 0
    ];
});
