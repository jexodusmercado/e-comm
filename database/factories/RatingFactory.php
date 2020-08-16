<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Rating;
use Faker\Generator as Faker;

$factory->define(Rating::class, function (Faker $faker) {
    return [
        'product_id' => $faker->numberBetween($min=1,$max=100),
        'rating' => $faker->numberBetween($min=1,$max=5),
        'comment' => $faker->text(),
        'buyer_id' => $faker->numberBetween($min=1,$max=10),
        'seller_id' => $faker->numberBetween($min=1,$max=10)
    ];
});
