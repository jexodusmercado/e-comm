<?php

use Illuminate\Database\Seeder;
use App\Rating;
class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Rating::class, 1000)->create();
    }
}
