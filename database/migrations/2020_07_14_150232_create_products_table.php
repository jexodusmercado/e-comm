<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('imageFront');
            $table->string('imageBack');
            $table->string('selectedProduct');
            $table->Integer('XXS');
            $table->Integer('XSM');
            $table->Integer('SML');
            $table->Integer('MED');
            $table->Integer('LRG');
            $table->Integer('XLG');
            $table->Integer('XXL');
            $table->Integer('totalQty');
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
