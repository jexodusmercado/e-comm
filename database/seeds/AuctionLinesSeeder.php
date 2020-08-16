<?php

use Illuminate\Database\Seeder;
use App\Auction_line;

class AuctionLinesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Auction_line::class, 500)->create();

    }
}
