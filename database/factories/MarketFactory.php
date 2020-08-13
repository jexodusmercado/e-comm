<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Market;
use Faker\Generator as Faker;

$factory->define(Market::class, function (Faker $faker) {
    return [
        'product_id' => $faker->unique()->numberBetween($min=1,$max=100),
        'active' => 1,
        'expired_at' => $faker->dateTimeBetween($startDate = 'now', $endDate = '+7 days', $timezone= null),
    ];
});
