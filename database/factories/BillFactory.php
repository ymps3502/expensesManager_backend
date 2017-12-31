<?php

use Faker\Generator as Faker;

$factory->define(App\Bill::class, function (Faker $faker) {
    return [
        'time' => $faker->dateTime($max = 'now', $timezone = 'Asia/Taipei')->format('Y-m-d H:i:s'),
        'role' => $faker->randomElement($array = array('自己', '女友', '其他')),
        'cost' => $faker->numberBetween($min = 10, $max = 1000),
        'note' => str_random(10),
    ];
});