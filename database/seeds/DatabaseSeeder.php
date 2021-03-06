<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
            'role'              => 0,
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
            'password'          => Hash::make('P@ssword'),
            'remember_token'    => Str::random(10),
        ]);


        $this->call([
            UserTableSeeder::class,
            ProductTableSeeder::class,
            MarketSeeder::class,
        ]);


    }
}
