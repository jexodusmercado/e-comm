<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$photoSuffix = [
    '20200725205209',
    '20200725202607',
    '20200725202509',
    '20200721201121'
];

$product = [
    'mens_crew',
    'mens_longsleeve',
    'mens_tank',
    'womens_crew',
    'mens_hoodie',
];


$factory->define(Product::class, function (Faker $faker) use ($photoSuffix, $product) {

    $image = $faker->randomElement($photoSuffix);
    $XXS = $faker->randomDigitNot(0);
    $XSM = $faker->randomDigitNot(0);
    $SML = $faker->randomDigitNot(0);
    $MED = $faker->randomDigitNot(0);
    $LRG = $faker->randomDigitNot(0);
    $XLG = $faker->randomDigitNot(0);
    $XXL = $faker->randomDigitNot(0);
    $totalQty = $XXS + $XSM + $SML + $MED + $LRG + $XLG + $XXL;

    return [
        'user_id' => $faker->randomDigitNot(0),
        'imageFront' => $image .'_front',
        'imageBack' => $image .'_back',
        'selectedProduct' => $faker->randomElement($product),
        'XXS' => $XXS,
        'XSM' => $XSM,
        'SML' => $SML,
        'MED' => $MED,
        'LRG' => $LRG,
        'XLG' => $XLG,
        'XXL' => $XXL,
        'totalQty' => $totalQty,
    ];
});
