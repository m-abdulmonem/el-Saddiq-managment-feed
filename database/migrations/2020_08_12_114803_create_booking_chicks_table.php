<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingChicksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_chicks', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->integer("code")->nullable();
            $table->integer("quantity")->nullable();
            $table->float("deposit")->nullable();
            $table->boolean("is_came")->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_chicks');
    }
}
