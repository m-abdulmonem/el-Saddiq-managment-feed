<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dailies', function (Blueprint $table) {
            $table->id();
            $table->string("number");
            $table->timestamp("time_in")->nullable();
            $table->timestamp("time_out")->nullable();
            $table->float("balance")->nullable();
            $table->float("net_sales")->nullable();
            $table->float("inc_dec")->nullable()->comment("increase or decrease of the daily box balance");
            $table->foreignId("user_id")->constrained();
            $table->softDeletes();
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
        Schema::dropIfExists('dailies');
    }
}
