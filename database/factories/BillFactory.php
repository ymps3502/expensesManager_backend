<?php

use Faker\Generator as Faker;

$factory->define(App\Bill::class, function (Faker $faker) {
    // $tag = factory(App\Tag::class)->create();
    // $tag->subtag = factory(App\subtag::class)->create();
    return [
        'time' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now', $timezone = 'Asia/Taipei')->format('Y-m-d H:i'),
        'role' => $faker->randomElement($array = array('自己', '女友', '其他')),
        'cost' => $faker->numberBetween($min = 10, $max = 1000),
        'note' => str_random(10),
        // 'tag_id' => $tag->id,
        // 'sub_tag_id' => $tag->subtag->id
    ];
});

$factory->state(App\Bill::class, 'thisWeek', function (Faker $faker) {
    return [
        'time' => $faker->dateTimeBetween($startDate = '-7 days', $endDate = 'now', $timezone = 'Asia/Taipei')->format('Y-m-d H:i')
    ];
});

$factory->state(App\Bill::class, 'thisMonth', function (Faker $faker) {
    return [
        'time' => $faker->dateTimeThisMonth($max = 'now', $timezone = 'Asia/Taipei')->format('Y-m-d H:i')
    ];
});

$factory->state(App\Bill::class, 'thisYear', function (Faker $faker) {
    return [
        'time' => $faker->dateTimeThisYear($max = 'now', $timezone = 'Asia/Taipei')->format('Y-m-d H:i')
    ];
});
