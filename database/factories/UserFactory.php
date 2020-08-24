<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$barangay = [
    'Sto Domingo',
    'Cutcut',
    'Pampang',
    'Sta Teresita',
    'Balibago'
];

$factory->define(User::class, function (Faker $faker) use ($barangay) {
    return [
        'role' => $faker->numberBetween($min = 1, $max = 1),
        'first_name' => $faker->firstName,
        'middle_name' => $faker->lastName,
        'last_name' => $faker->lastName,
        'address1' => $faker->streetAddress,
        'barangay' => $faker->randomElement($barangay),
        'city' => 'Angeles City',
        'province' => 'Pampanga',
        'mobile_number' => '09' . $faker->randomNumber($nbDigits = 9, $strict = true),
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});
