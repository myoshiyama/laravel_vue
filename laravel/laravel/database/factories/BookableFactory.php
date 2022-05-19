<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bookable;
use Faker\Generator as Faker;

$suffix = [
    'ホテル',
    '旅館',
    'コテージ',
    'キャンプ場',
    'bnb',
    '小部屋',
    '大部屋',
    '中部屋',
    '宴会場'
];

$factory->define(Bookable::class, function (Faker $faker) use($suffix) {
    return [
        'title' => $faker->city . ' ' . Arr::random($suffix),
        'description' => $faker->text(),
        'price' => random_int(15,600)
    ];
});
