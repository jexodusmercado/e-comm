<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('role')->default(1);
            $table->smallInteger('ratings')->default(0);
            $table->string('verification_id_img')->nullable();
            $table->string('profile_img')->default('no_profile.jpg');
            $table->string('company_name')->nullable();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('address1');
            $table->string('address2')->nullable();
            $table->string('barangay');
            $table->string('city');
            $table->string('province');
            $table->string('country')->default('PH');
            $table->string('mobile_number');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
