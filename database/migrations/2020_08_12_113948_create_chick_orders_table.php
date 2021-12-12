<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChickOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chick_orders', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("name")->nullable();
            $table->integer("quantity")->nullable();
            $table->float("price")->nullable();
            $table->float("chick_price")->nullable();
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
        Schema::dropIfExists('chick_orders');
    }
}
