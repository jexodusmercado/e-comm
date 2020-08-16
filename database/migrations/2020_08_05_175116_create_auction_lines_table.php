<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuctionLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auction_lines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->index();
            $table->foreign('product_id')->references('id')->on('products');
            $table->unsignedBigInteger('seller_id')->index();
            $table->foreign('seller_id')->references('id')->on('users');
            $table->bigInteger('offer_amount');
            $table->bigInteger('shipping_amount');
            $table->smallInteger('accepted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auction_lines');
    }
}
