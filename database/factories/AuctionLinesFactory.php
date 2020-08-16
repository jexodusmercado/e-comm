<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Auction_line;
use Faker\Generator as Faker;

$factory->define(Auction_line::class, function (Faker $faker) {
    return [
        'product_id' => $faker->numberBetween($min = 1, $max = 100),
        'seller_id' => $faker->numberBetween($min = 1, $max = 10),
        'offer_amount' => $faker->randomNumber($nbDigits = 4, $strict = true),
        'shipping_amount' => '50'
    ];
});
