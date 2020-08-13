<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(User::class, function (Faker $faker) {
    return [
        'first_name'        => 'Admin',
        'middle_name'       => '',
        'last_name'         => 'Debuhu',
        'address1'          => 'PH',
        'barangay'          => 'PH',
        'city'              => 'Angeles City',
        'province'          => 'Pampanga',
        'mobile_number'     => '09353311151',
        'email'             => 'admin@debuhu.ph',
        'email_verified_at' => now(),
        'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token'    => Str::random(10),
    ];
});
