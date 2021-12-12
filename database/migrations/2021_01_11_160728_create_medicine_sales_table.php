<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicineSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicine_sales', function (Blueprint $table) {
            $table->id();
            $table->integer("quantity");
            $table->float("price")->nullable();
            $table->foreignId("medicine_id")->constrained("medicines");
            $table->foreignId("user_id")->constrained("users");
            $table->foreignId("daily_id")->constrained("dailies");
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
        Schema::dropIfExists('medicine_sales');
    }
}
