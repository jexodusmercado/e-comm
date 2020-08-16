<?php

use Illuminate\Database\Seeder;
use App\Market;

class MarketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Market::class, 100)->create();
    }
}
